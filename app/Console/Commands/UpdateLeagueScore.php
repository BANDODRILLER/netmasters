<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Goutte\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Scores; // Adjust the namespace according to your project structure


class UpdateLeagueScore extends Command
{
    protected $signature = 'premier-scores:update';
    protected $description = 'Update Premier League score from thefishy.co.uk';
    public function handle()
    {
        // Create a new Goutte client
        $client = new Client();
        $tableDataArray = [];

        // Define the range of tables you want to fetch
        $tableRange = range(0, 900); // Adjust as needed

        // Define the season parameter
        $season = 21; // Adjust as needed

        // Loop through the table numbers
        foreach ($tableRange as $tableNumber) {
            // Fetch data from the current table
            $crawler = $client->request('GET', "https://thefishy.co.uk/football-results.php?table=$tableNumber&season=$season");

            // Extract table name
            $tableName = $this->extractTableName($crawler);

            // Extract table data
            $tableData = $this->extractTableData($crawler);

            // Pass league name to updateDatabase function
            $this->updateDatabase($tableData, $tableName);
        }

        $this->info('Football fixtures updated successfully!');
    }

    private function extractTableName($crawler)
    {
        $leagueName = '';

        // Extract league name from breadcrumb
        $crawler->filter('ul.breadcrumb li.active')->each(function ($element) use (&$leagueName) {
            $leagueName = $element->text();
        });

        return $leagueName;
    }
    private function extractTableData($crawler)
    {
        $tableData = [];
        $currentDate = '';

        // Extract data from the table
        // Extract data from the table
        $crawler->filter('table tr')->each(function ($row) use (&$tableData, &$currentDate) {
            // Check if the row contains the date
            if ($row->filter('th[colspan="5"]')->count()) {
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
    private function updateDatabase($tableData, $leagueName)
    {
        foreach ($tableData as $data) {
            $date = $data[0];
            $time = $data[1];
            $homeTeam = $data[2];
            $awayTeam = $data[4]; // Use index 4 because index 3 contains the score

            // Assuming $score is in the format "0-2", you can further process it if needed
            $score = $data[3];

            // Create or update the record in the scores table
            Scores::updateOrCreate(
                [
                    'date' => $date,
                    'time' => $time,
                    'home_team' => $homeTeam,
                    'away_team' => $awayTeam,
                    'league_name' => $leagueName,
                ],
                ['score' => $score]
            );
        }
    }

}
