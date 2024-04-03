<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Goutte\Client;
use Illuminate\Support\Facades\DB;
use App\Models\PremierLeagueTable;
use App\Models\Fixtures;
use Illuminate\Support\Facades\Log;

class UpdateFixtureOdds extends Command
{
    protected $signature = 'fixture-odds:update';
    protected $description = 'Update Fixture Odds from a specified source';

    public function handle($date = null)
    {
        // Get today's date
        $todayDateTime = $date ?: Carbon::now()->format('D d/m : H:i');

        // Retrieve fixtures for today and later dates
        $fixtures = Fixtures::where('match_datetime','>=', $todayDateTime	)->get();




        foreach ($fixtures as $fixture) {
            $homeTeamData = PremierLeagueTable::where('team', $fixture->home_team)->first();
            $awayTeamData = PremierLeagueTable::where('team', $fixture->away_team)->first();

            // Call private functions to calculate and display values
            $homePpg = $this->calculateHomePpg($homeTeamData);
            $awayPpg = $this->calculateAwayPpg($awayTeamData);
            $homeAttack = $this->calculateHomeAttack($homeTeamData);
            $awayAttack = $this->calculateAwayAttack($awayTeamData);
            $homeDef = $this->calculateHomeDef($homeTeamData);
            $awayDef = $this->calculateAwayDef($awayTeamData);
            $homeAvg = $this->calculateHomeAvg($homeTeamData);
            $awayAvg = $this->calculateAwayAvg($awayTeamData);
            $homeExactGoal = $this->calculateHomeExactGoal($homeTeamData, $awayTeamData);
            $awayExactGoal = $this->calculateAwayExactGoal($awayTeamData, $homeTeamData);

            // Calculate correct scores based on Poisson distribution
            $cs1 = $this->calculateCorrectScore($homePpg, $awayPpg);
            $cs2 = $this->calculateCorrectScore($homeAttack, $awayAttack);
            $cs3 = $this->calculateCorrectScore($homeAvg, $awayAvg);


            // Calculate odds probabilities
            $oddsProbabilities = $this->calculateOddsProbabilities(
                $this->calculatePoissonDistribution($homeAttack),
                $this->calculatePoissonDistribution($awayAttack)
            );
            $this->updateFixtureData($fixture, $cs1, $cs2, $cs3, $oddsProbabilities);

        }

        $this->info('Fixture Odds updated successfully!');
    }

    private function calculateOddsProbabilities($homeDistribution, $awayDistribution)
    {

        $oddsProbabilities = [];

        // Variable 1
        $variable1 = 0;
        for ($i = 1; $i <= 5; $i++) {
            for ($j = 0; $j <= $i - 1; $j++) {
                $variable1 += $homeDistribution[$i] * $awayDistribution[$j];
            }
        }
        $oddsProbabilities['1'] = $variable1;


        $variableX = 0;
        for ($i = 0; $i <= 5; $i++) {
            $variableX += $homeDistribution[$i] * $awayDistribution[$i];
        }
        $oddsProbabilities['X'] = $variableX;

        // Variable 2
        $variable2 = 0;
        for ($i = 0; $i <= 4; $i++) {
            for ($j = $i + 1; $j <= 5; $j++) {
                $variable2 += $homeDistribution[$i] * $awayDistribution[$j];
            }
        }
        $oddsProbabilities['2'] = $variable2;


        // Normalize probabilities
        $totalProbability = $oddsProbabilities['1'] + $oddsProbabilities['X'] + $oddsProbabilities['2'];

        // Check if total probability is not zero to avoid division by zero
        if ($totalProbability != 0) {
            $oddsProbabilities['1'] = round($oddsProbabilities['1'] / $totalProbability * 100, 2);
            $oddsProbabilities['X'] = round($oddsProbabilities['X'] / $totalProbability * 100, 2);
            $oddsProbabilities['2'] = round($oddsProbabilities['2'] / $totalProbability * 100, 2);
        }
        return $oddsProbabilities;
    }

    private function updateFixtureData($fixture, $cs1, $cs2, $cs3, $oddsProbabilities)
    {
        // Update the fields in the fixture object with the calculated values
        $fixture->cs1 = $cs1;
        $fixture->cs2 = $cs2;
        $fixture->cs3 = $cs3;
        $fixture->odds_1 = $oddsProbabilities['1'];
        $fixture->odds_X = $oddsProbabilities['X'];
        $fixture->odds_2 = $oddsProbabilities['2'];

        // You can update other fields as needed based on your calculations

        // Save the changes to the database
        $fixture->save();
        $this->info('Fixture Odds and CS updated successfully for ' . $fixture->home_team . ' vs ' . $fixture->away_team);

    }


    private function calculateCorrectScore($lambdaHome, $lambdaAway)
    {
        // Calculate Poisson distribution for home team
        $homeDistribution = $this->calculatePoissonDistribution($lambdaHome);

        // Calculate Poisson distribution for away team
        $awayDistribution = $this->calculatePoissonDistribution($lambdaAway);

        // Find the most likely scores for home and away teams
        $homeScore = array_search(max($homeDistribution), $homeDistribution);
        $awayScore = array_search(max($awayDistribution), $awayDistribution);

        // Return the correct score
        return $homeScore . ':' . $awayScore;
    }

    private function calculatePoissonDistribution($lambda)
    {
        $distribution = [];
        $sum = 0;

        for ($x = 0; $x <= 5; $x++) {
            $probability = exp(-$lambda) * pow($lambda, $x) / $this->factorial($x);
            $distribution[$x] = $probability;
            $sum += $probability;
        }

        // Normalize the distribution to ensure the sum is 1
        foreach ($distribution as &$value) {
            $value /= $sum;
        }

        // If the sum is not exactly 1 due to rounding, adjust the last element
        $distribution[5] += 1 - array_sum($distribution);

        return $distribution;
    }


    // Add a new private function to calculate factorial
    private function factorial($n)
    {
        return ($n == 0) ? 1 : $n * $this->factorial($n - 1);
    }


    private function calculateHomePpg($teamData)
    {
        // Check if the necessary attributes are present in the team data
        if (isset($teamData->points) && isset($teamData->played) && $teamData->played > 0) {
            // Calculate and return the points per game
            return $teamData->points / $teamData->played;
        } else {
            // Handle the case where the necessary attributes are missing or played is 0 to avoid division by zero
            return 0;
        }
    }

    private function calculateAwayPpg($teamData)
    {
        // Check if the necessary attributes are present in the team data
        if (isset($teamData->points) && isset($teamData->played) && $teamData->played > 0) {
            // Calculate and return the points per game
            return $teamData->points / $teamData->played;
        } else {
            // Handle the case where the necessary attributes are missing or played is 0 to avoid division by zero
            return 0;
        }
    }

    private function calculateHomeAttack($teamData)
    {
        // Check if the necessary attributes are present in the team data
        if (isset($teamData->f) && isset($teamData->played) && $teamData->played > 0) {
            // Calculate and return the attack value for the home team
            return $teamData->f / $teamData->played;
        } else {
            // Handle the case where the necessary attributes are missing or played is 0 to avoid division by zero
            return 0;
        }
    }

    private function calculateAwayAttack($teamData)
    {
        // Check if the necessary attributes are present in the team data
        if (isset($teamData->f) && isset($teamData->played) && $teamData->played > 0) {
            // Calculate and return the attack value for the away team
            return $teamData->f / $teamData->played;
        } else {
            // Handle the case where the necessary attributes are missing or played is 0 to avoid division by zero
            return 0;
        }
    }
    private function calculateHomeDef($teamData)
    {
        // Check if the necessary attributes are present in the team data
        if (isset($teamData->a) && isset($teamData->played) && $teamData->played > 0) {
            // Calculate and return the defense value for the home team
            return $teamData->a / $teamData->played;
        } else {
            // Handle the case where the necessary attributes are missing or played is 0 to avoid division by zero
            return 0;
        }
    }

    private function calculateAwayDef($teamData)
    {
        // Check if the necessary attributes are present in the team data
        if (isset($teamData->a) && isset($teamData->played) && $teamData->played > 0) {
            // Calculate and return the defense value for the away team
            return $teamData->a / $teamData->played;
        } else {
            // Handle the case where the necessary attributes are missing or played is 0 to avoid division by zero
            return 0;
        }
    }

    private function calculateHomeAvg($teamData)
    {
        // Check if the necessary attributes are present in the team data
        if (isset($teamData->f) && isset($teamData->a) && $teamData->a > 0) {
            // Calculate and return the average value for the home team
            return $teamData->f / $teamData->a;
        } else {
            // Handle the case where the necessary attributes are missing or a is 0 to avoid division by zero
            return 0;
        }
    }

    private function calculateAwayAvg($teamData)
    {
        // Check if the necessary attributes are present in the team data
        if (isset($teamData->f) && isset($teamData->a) && $teamData->a > 0) {
            // Calculate and return the average value for the away team
            return $teamData->f / $teamData->a;
        } else {
            // Handle the case where the necessary attributes are missing or a is 0 to avoid division by zero
            return 0;
        }
    }

    private function calculateHomeExactGoal($homeTeamData, $awayTeamData)
    {
        // Check if the necessary attributes are present in the team data
        if (
            isset($homeTeamData->f) &&
            isset($homeTeamData->a) &&
            isset($awayTeamData->a) &&
            $awayTeamData->a > 0
        ) {
            // Calculate and return the exact goal number for the home team
            return $homeTeamData->f / ($awayTeamData->a * $this->calculateAwayDef($awayTeamData));
        } else {
            // Handle the case where the necessary attributes are missing or a is 0 to avoid division by zero
            return 0;
        }
    }



    private function calculateAwayExactGoal($awayTeamData, $homeTeamData)
    {
        // Check if the necessary attributes are present in the team data
        if (
            isset($awayTeamData->f) &&
            isset($awayTeamData->a) &&
            isset($homeTeamData->a) &&
            $homeTeamData->a > 0
        ) {
            // Calculate and return the exact goal number for the away team
            return $awayTeamData->f / ($homeTeamData->a * $this->calculateHomeDef($homeTeamData));
        } else {
            // Handle the case where the necessary attributes are missing or a is 0 to avoid division by zero
            return 0;
        }
    }


}

