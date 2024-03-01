<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Goutte\Client;
use Illuminate\Support\Facades\DB;

class UpdatePremierLeagueFixture extends Command
{
    protected $signature = 'premier-fixture:update';
    protected $description = 'Update Premier League Fixture from thefishy.co.uk';






    public function handle()
    {
        // Create a new Goutte client
        $client = new Client();
        $tableNumbers = range(1, 900);
//                $tableNumbers = range(1, 2);

        $tableDataArray = [];

        // Loop through the table numbers
        foreach ($tableNumbers as $tableNumber) {
            // Fetch data from the current table
            $crawler = $client->request('GET', 'https://thefishy.co.uk/football-fixtures.php?table=' . $tableNumber);

            // Extract table name
            $tableName = $this->extractTableName($crawler);

            // Extract table data
            $tableData = $this->extractTableData($crawler);

            // Extract table date

            $this->updateDatabase($tableData, $tableName);
        }

        $this->info('Football fixtures updated successfully!');
    }

    private function fetchData($url)
    {
        try {
            $client = new Client();
            return $client->request('GET', $url);
        } catch (\Exception $e) {
            $this->error('Error fetching data: ' . $e->getMessage());
            return null;
        }
    }

    private function extractTableData($crawler)
    {
        $tableData = [];
        $currentDate = '';

        // Extract data from the table
        $crawler->filter('table tr')->each(function ($row) use (&$tableData, &$currentDate) {
            // Check if the row contains the date
            if ($row->filter('th[colspan]:first-child')->count()) {
                $currentDate = $row->text();
                return;
            }

            $rowData = $row->filter('td')->each(function ($column) {
                return $column->text();
            });

            // Check if the row contains fixture data (e.g., time, teams, odds)
            if (!empty($rowData) && count($rowData) === 5) {
                // Add the date to the rowData
                array_unshift($rowData, $currentDate);
                $tableData[] = $rowData;
            }
        });

        return $tableData;
    }

    private function updateDatabase($tableData, $tableName)
    {
        foreach ($tableData as $data) {
            // Skip rows with insufficient data
            if (count($data) < 6) {
                continue;
            }

            $date = preg_replace('/1X2$/', '', $data[0] ?? null);
            $time = $data[1] ?? null;

            // Split the team data into home_team and away_team
            $teams = explode(' v ', $data[2] ?? '');

            if (count($teams) !== 2) {
                // Invalid team data, skip this row
                continue;
            }

            $fixtureData = [
                'match_datetime' => $date . ' : ' . $time,
                'home_team' => $teams[0],
                'away_team' => $teams[1],
                'league' => $tableName,
                // Add other columns as needed
            ];

            // Check if a similar entry already exists
            $existingEntry = DB::table('fixtures')
                ->where('match_datetime', $fixtureData['match_datetime'])
                ->where('home_team', $fixtureData['home_team'])
                ->where('away_team', $fixtureData['away_team'])
                ->first();

            // Insert the new data only if no similar entry exists
            if (!$existingEntry) {
                try {
                    // Insert the new data
                    DB::table('fixtures')->insert($fixtureData);

                    // Dump a message for each successfully stored entry
                    dump('Entry stored successfully:', $fixtureData);
                } catch (\Exception $e) {
                    // Log or print the error message
                    dump('Error storing entry:', $e->getMessage());
                }
            } else {
                // Entry already exists, skip insertion and provide a message
                dump('Entry already exists, skipping insertion:', $fixtureData);
            }
        }
    }

    /**
     * Extract table name from a Goutte crawler
     *
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     * @return string
     */
    private function extractTableName($crawler)
    {
        // Extract table name logic based on your HTML structure
        // Modify the following line accordingly
        $tableName = $crawler->filter('h1')->text();

        return $tableName;
    }



}
