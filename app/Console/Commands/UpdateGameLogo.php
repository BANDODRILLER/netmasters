<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\DomCrawler\Crawler;

class UpdateGameLogo extends Command
{
    protected $signature = 'premier-logo:update';
    protected $description = 'Update Premier League score from thefishy.co.uk';

    public function handle()
    {
        // Set the base URL
        $baseUrl = 'https://thefishy.co.uk/teams.php?table=';

        // Define the range of tables you want to scrape
        $tableRange = range(78, 900); // Adjust the range accordingly

        // Check if the "products" folder exists, create it if not
        $productsFolder = 'public/products';
        if (!Storage::exists($productsFolder)) {
            Storage::makeDirectory($productsFolder);
        }

        // Initialize the console output
        $output = new ConsoleOutput();

        foreach ($tableRange as $tableNumber) {
            $url = $baseUrl . $tableNumber;

            // Use Goutte to scrape the webpage
            $client = new Client();
            $crawler = $client->request('GET', $url);

            // Extract team information
            $teams = $crawler->filter('.team-card');

            // Initialize the progress bar for each table
            $progressBar = new ProgressBar($output, count($teams));
            $progressBar->setFormat('verbose');
            $progressBar->start();

            // Inside the foreach loop for teams
            foreach ($teams as $team) {
                $teamCrawler = new Crawler($team);

                // Get the team name using a different approach
                $teamName = $teamCrawler->filterXPath('//div[contains(@class, "team-card")]/a[last()]')->text();

                $imageUrl = $teamCrawler->filter('img')->attr('src');

                // Skip the team if the image URL is empty
                if (empty($imageUrl)) {
                    continue; // Move to the next iteration of the loop
                }

                // Try to download the image and store it in the public/products folder
                $imageContent = @file_get_contents($imageUrl);

                // Check if the image download was successful
                if ($imageContent !== false) {
                    $imageName = strtolower(str_replace(' ', '_', $teamName)) . '.png';
                    $imagePath = $productsFolder . '/' . $imageName;
                    Storage::put($imagePath, $imageContent);

                    // Update the database with the image path
                    DB::table('teams')->where('team_name_column', $teamName)
                        ->update(['image_path_column' => $imagePath]);
                }

                // Advance the progress bar
                $progressBar->advance();
            }

            // Finish the progress bar for each table
            $progressBar->finish();
            $output->writeln("\nTeam logos for Table $tableNumber updated successfully!");
        }

        $output->writeln("\nAll team logos updated successfully!");
    }

}
