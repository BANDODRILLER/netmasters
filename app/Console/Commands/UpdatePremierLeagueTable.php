<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use Illuminate\Support\Facades\DB;

class UpdatePremierLeagueTable extends Command
{
    protected $signature = 'premier-league:update';
    protected $description = 'Update Premier League Table from thefishy.co.uk';

    public function handle()
    {
        $client = new Client();

        $tableData = [];

        // Define the range of numbers for the table URLs
        $tableNumbers = range(1, 1000); // Adjust the range as needed
//        $tableNumbers = range(1, 2); // Adjust the range as needed


        foreach ($tableNumbers as $tableNumber) {
            $url = 'https://thefishy.co.uk/formtable.php?table=' . $tableNumber;

            $crawler = $client->request('GET', $url);

            // Check if the caption node exists
            $captionNode = $crawler->filter('table.table-condensed caption');
            if ($captionNode->count() === 0) {
                // Skip the iteration if no caption node is found
                continue;
            }

            // Extract table name from the top of the table
            $tableName = $captionNode->text();

            // Dump the table name for debugging
            dump($tableName);

            // Extract table data
            $tableData[$tableName] = $crawler->filter('table.table-condensed')->eq(0)->filter('tr')->each(function ($tr, $i) {
                $rowData = $tr->filter('td')->each(function ($td) {
                    return $td->text();
                });

                // Filter out rows with empty values or unwanted data
                $filteredRowData = array_filter($rowData, function ($value) {
                    return trim($value) !== '';
                });

                return array_values($filteredRowData);
            });

            // Remove header row
            array_shift($tableData[$tableName]);

            // Update database with the extracted data
            foreach ($tableData[$tableName] as $data) {
                // Initialize an empty array for the database update
                $updateArray = ['team' => $data[1], 'table_name' => $tableName];

                // Specify the keys and their corresponding indexes
                $keyIndexes = [
                    'position' => 0,
                    'played' => 2,
                    'draw' => 4,
                    'win' => 3,
                    'loss' => 5,
                    'f' => 6,
                    'a' => 7,
                    'goal_difference' => 8,
                    'points' => 9,
                    'btts' => 10,
                    'last_6_results' => 11,
                    'g' => 12,
                    'km' => 13,
                    'Next_match' => 14,
                ];

                foreach ($keyIndexes as $key => $index) {
                    // Check if the key index exists before accessing it
                    if (isset($data[$index])) {
                        $updateArray[$key] = $data[$index];
                    } else {
                        // Skip the iteration if any key is missing
                        continue 2;
                    }
                }

                // Update or insert into the database
                DB::table('premier_league_tables')->updateOrInsert(
                    ['team' => $data[1], 'table_name' => $tableName],
                    $updateArray
                );
            }
        }

        $this->info('Premier League Tables updated successfully!');
    }





}
