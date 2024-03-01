<?php

namespace App\Http\Controllers;

use App\Models\PremierLeagueTable;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class LeaguesController extends Controller
{
    public function tables()
    {
        $table = PremierLeagueTable::all();
        return view('home.tables', compact('table'));
    }


    public function fetchLeagueMatches()
    {
        $apiKey = 'example'; // Replace with your actual API key
        $leagueId = 2012;

        $client = new Client();

        try {
            $response = $client->get("https://api.football-data-api.com/league-matches?key={$apiKey}&league_id={$leagueId}");
            $data = json_decode($response->getBody(), true);

            // Pass the API data to the Blade view
            return view('home.data', ['matches' => $data['data']]);
        } catch (\Exception $e) {
            // Handle any errors or exceptions that occur during the API request
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
