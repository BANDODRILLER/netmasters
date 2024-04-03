<?php

namespace App\Http\Controllers;

use App\Models\Fixtures;
use App\Models\Leagues;
use App\Models\PremierLeagueTable;
use App\Models\Scores;
use Goutte\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Symfony\Component\Console\Completion\Output\FishCompletionOutput;
use function Symfony\Component\Translation\t;


class HomePageController extends Controller
{




    public function index()
    {

        list($todayDate, $table) = $this->getTableData();
        return view('home.userpage', compact('table', 'todayDate'));
    }
    public function percentages()
    {
        list($todayDate, $table) = $this->getTableData();
        return view('home.percentages', compact('table', 'todayDate'));
    }

    public function getUpdatedScores($date = null)
    {
        $todayDate = $date ?: Carbon::now()->format('D d/m');

        $fixtures = Fixtures::where('match_datetime', 'LIKE', $todayDate . '%')->where(function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('odds_1', '>', 0)
                    ->where('odds_2', '>', 0);
            })
                ->orWhere(function ($subquery) {
                    $subquery->where('odds_1', '=', 0)
                        ->where('odds_2', '>', 0);
                })
                ->orWhere(function ($subquery) {
                    $subquery->where('odds_1', '>', 0)
                        ->where('odds_2', '=', 0);
                });
        })
            ->get();

        $updatedScores = [];

        foreach ($fixtures as $fixture) {
            $dateTimeParts = explode(' : ', $fixture->match_datetime);
            $combinedDateTime = $dateTimeParts[0] . ' ' . $dateTimeParts[1];
            $formattedDate = Carbon::createFromFormat('D d/m H:i', $combinedDateTime)->format('D d-M-Y');

            $score = Scores::where('home_team', 'LIKE', trim($fixture->home_team))
                ->where('away_team', 'LIKE', trim($fixture->away_team))
                ->where('date', $formattedDate)
                ->first();

            $updatedScores[] = [
                'id' => $fixture->id,
                'score' => $score ? $score->score : null,
            ];
        }

        return response()->json($updatedScores);
    }



    private function getTableData($date = null)
    {
        $todayDate = $date ?: Carbon::now()->format('D d/m');
        $fixtures = Fixtures::where('match_datetime', 'LIKE', $todayDate . '%')
            ->where(function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('odds_1', '>', 0)
                        ->where('odds_2', '>', 0);
                })
                    ->orWhere(function ($subquery) {
                        $subquery->where('odds_1', '=', 0)
                            ->where('odds_2', '>', 0);
                    })
                    ->orWhere(function ($subquery) {
                        $subquery->where('odds_1', '>', 0)
                            ->where('odds_2', '=', 0);
                    });
            })
            ->get();

        $fixtures->each(function ($fixture) {
            // Split the date and time parts
            $dateTimeParts = explode(' : ', $fixture->match_datetime);

            // Combine the date and time in a format Carbon can parse
            $combinedDateTime = $dateTimeParts[0] . ' ' . $dateTimeParts[1];

            // Parse the combined date and time
            $fixtureDate = Carbon::createFromFormat('D d/m H:i', $combinedDateTime);


            // Calculate the tip based on odds
            $maxOdds = max($fixture->odds_1, $fixture->odds_X, $fixture->odds_2);
            $fixture->tip = ($maxOdds == $fixture->odds_1) ? '1' : (($maxOdds == $fixture->odds_X) ? 'X' : '2');

            // Convert team names to lowercase for image filenames
            $lowercaseHomeTeam = strtolower($fixture->home_team);
            $lowercaseAwayTeam = strtolower($fixture->away_team);

            // Replace spaces with underscores in team names for image filenames
            $formattedHomeTeam = str_replace(' ', '_', $lowercaseHomeTeam);
            $formattedAwayTeam = str_replace(' ', '_', $lowercaseAwayTeam);

            // Fetch and add the team logos to the fixture
            $fixture->home_team_logo_url = '/assets/img/' . $formattedHomeTeam . '.png';
            $fixture->away_team_logo_url = '/assets/img/' . $formattedAwayTeam . '.png';


        });
        return [$todayDate, $fixtures];
    }




    public function percentagedate(Request $request)
    {
        $date = $request->input('new');
        $formattedDate = $this->getFormattedDate($date);

        $table = $this->processFixtures($formattedDate);

        return view('home.percentagedate', compact('table'));
    }

    public function date(Request $request)
    {
        $date = $request->input('new');
        $formattedDate = $this->getFormattedDate($date);

        $table = $this->processFixtures($formattedDate);

        return view('home.date', compact('table'));
    }

    private function getFormattedDate($date)
    {
        return date('d/m', strtotime($date));
    }

    private function processFixtures($formattedDate)
    {
        $fixtures = Fixtures::where('match_datetime', 'LIKE', "%$formattedDate%")->where(function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('odds_1', '>', 0)
                    ->where('odds_2', '>', 0);
            })
                ->orWhere(function ($subquery) {
                    $subquery->where('odds_1', '=', 0)
                        ->where('odds_2', '>', 0);
                })
                ->orWhere(function ($subquery) {
                    $subquery->where('odds_1', '>', 0)
                        ->where('odds_2', '=', 0);
                });
        })
            ->get();

        $table = $fixtures->map(function ($fixture) use ($formattedDate) {
            $dateTimeParts = explode(' : ', $fixture->match_datetime);
            $combinedDateTime = $dateTimeParts[0] . ' ' . $dateTimeParts[1];
            $fixtureDate = Carbon::createFromFormat('D d/m H:i', $combinedDateTime);
            $formattedDate = $fixtureDate->format('D d-M-Y');

            $score = $this->getFixtureScore($fixture, $formattedDate);

            $fixture->score = $score ? $score->score : null;
            $fixture->tip = $this->calculateTip($fixture);
            $this->addTeamLogos($fixture);

            return $fixture;
        });

        return $table;
    }

    private function getFixtureScore($fixture, $formattedDate)
    {
        return Scores::where('home_team', 'LIKE', trim($fixture->home_team))
            ->where('away_team', 'LIKE', trim($fixture->away_team))
            ->where('date', $formattedDate)
            ->first();
    }

    private function calculateTip($fixture)
    {
        $maxOdds = max($fixture->odds_1, $fixture->odds_X, $fixture->odds_2);
        return ($maxOdds == $fixture->odds_1) ? '1' : (($maxOdds == $fixture->odds_X) ? 'X' : '2');
    }

    private function addTeamLogos($fixture)
    {
        $lowercaseHomeTeam = strtolower($fixture->home_team);
        $lowercaseAwayTeam = strtolower($fixture->away_team);
        $formattedHomeTeam = str_replace(' ', '_', $lowercaseHomeTeam);
        $formattedAwayTeam = str_replace(' ', '_', $lowercaseAwayTeam);

        $fixture->home_team_logo_url = '/assets/img/' . $formattedHomeTeam . '.png';
        $fixture->away_team_logo_url = '/assets/img/' . $formattedAwayTeam . '.png';
    }


    public function htft()
    {
        list($todayDate, $table) = $this->getTableData();
        return view('home.htft', compact('table'));
    }

    public function pickofday()
    {
        list($todayDate, $table) = $this->getTableData();
        return view('home.pickofday', compact('table'));
    }

    public function overunder()
    {
        $table = Fixtures::all();
        $table->each(function ($t) {
            $maxOdds = max($t->odds_1, $t->odds_X, $t->odds_2);
            $t->tip = ($maxOdds == $t->odds_1) ? '1' : (($maxOdds == $t->odds_X) ? 'X' : '2');
        });
        return view('home.overunder', compact('table'));
    }




    public function matchdetails(Request $request)
    {
        $id = $request->query('id');
        list($home_team, $away_team, $homeleague, $teamData) = $this->getFixtureDetails($id);

        $table = Fixtures::where('id', $id)->where(function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('odds_1', '>', 0)
                    ->where('odds_2', '>', 0);
            })
                ->orWhere(function ($subquery) {
                    $subquery->where('odds_1', '=', 0)
                        ->where('odds_2', '>', 0);
                })
                ->orWhere(function ($subquery) {
                    $subquery->where('odds_1', '>', 0)
                        ->where('odds_2', '=', 0);
                });
        })
            ->get();

        $this->processMatchDetails($table);

        return view('home.matchdetail', compact('table', 'teamData', 'home_team', 'away_team'));
    }

    public function both()
    {
        $table = Fixtures::all();
        $this->processMatchDetails($table);

        return view('home.both', compact('table'));
    }

    public function double($date = null)
    {
        $todayDate = $date ?: Carbon::now()->format('D d/m');
        $allfixtures = Fixtures::where('match_datetime', 'LIKE', $todayDate . '%')->where(function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('odds_1', '>', 0)
                    ->where('odds_2', '>', 0);
            })
                ->orWhere(function ($subquery) {
                    $subquery->where('odds_1', '=', 0)
                        ->where('odds_2', '>', 0);
                })
                ->orWhere(function ($subquery) {
                    $subquery->where('odds_1', '>', 0)
                        ->where('odds_2', '=', 0);
                });
        })
            ->get();
        $fixtures = $this->filterFixtures($allfixtures);

        $this->processMatchDetails($fixtures);

        return view('home.double', compact('fixtures'));
    }

    public function doubledate(Request $request)
    {
        $date = $request->query('new');
        $formattedDate = date('d/m', strtotime($date));
        $allfixtures = Fixtures::where('match_datetime', 'LIKE', "%$formattedDate%")->where(function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('odds_1', '>', 0)
                    ->where('odds_2', '>', 0);
            })
                ->orWhere(function ($subquery) {
                    $subquery->where('odds_1', '=', 0)
                        ->where('odds_2', '>', 0);
                })
                ->orWhere(function ($subquery) {
                    $subquery->where('odds_1', '>', 0)
                        ->where('odds_2', '=', 0);
                });
        })
            ->get();
        $fixtures = $this->filterFixtures($allfixtures);

        $this->processMatchDetails($fixtures);

        return view('home.doubledate', compact('fixtures'));
    }

    private function getFixtureDetails($id)
    {
        $home_team = Fixtures::where('id', $id)->value('home_team');
        $away_team = Fixtures::where('id', $id)->value('away_team');

        // Make the team name comparison case-insensitive
        $homeleague = PremierLeagueTable::whereRaw('LOWER(team) = LOWER(?)', [$home_team])->value('table_name');

        $teamData = PremierLeagueTable::where('table_name', $homeleague)->get();

        return [$home_team, $away_team, $homeleague, $teamData];
    }


    private function filterFixtures($fixtures)
    {
        $filteredFixtures = $fixtures->filter(function ($fixture) {
            $odds_1 = (float)$fixture->odds_1;
            $odds_X = (float)$fixture->odds_X;
            $odds_2 = (float)$fixture->odds_2;

            return $odds_1 > 65.00 || $odds_X > 65.00 || $odds_2 > 65.00;
        });

        return $fixtures->reject(function ($fixture) use ($filteredFixtures) {
            return $filteredFixtures->contains('id', $fixture->id);
        });
    }

    private function processMatchDetails($fixtures)
    {
        $fixtures->each(function ($fixture) {
            $this->processFixtureDate($fixture);

            $score = Scores::where('home_team', 'LIKE', trim($fixture->home_team))
                ->where('away_team', 'LIKE', trim($fixture->away_team))
                ->whereRaw('1') // Remove the COLLATE statement
                ->limit(1)
                ->first();


            $fixture->score = $score ? $score->score : null;

            $this->calculateFixtureTip($fixture);

            $this->setTeamLogos($fixture);
        });
    }

    private function processFixtureDate($fixture)
    {
        $dateTimeParts = explode(' : ', $fixture->match_datetime);
        $combinedDateTime = $dateTimeParts[0] . ' ' . $dateTimeParts[1];
        $fixtureDate = Carbon::createFromFormat('D d/m H:i', $combinedDateTime);
        $formattedDate = $fixtureDate->format('D d-M-Y');
        $fixture->formattedDate = $formattedDate;
    }

    private function calculateFixtureTip($fixture)
    {
        $odds_1 = (float)$fixture->odds_1;
        $odds_X = (float)$fixture->odds_X;
        $odds_2 = (float)$fixture->odds_2;
        $minOdd = min($odds_1, $odds_X, $odds_2);

        if ($minOdd == $odds_1) {
            $fixture->tip = '2X';
        } elseif ($minOdd == $odds_X) {
            $fixture->tip = '12';
        } else {
            $fixture->tip = '1X';
        }

        if ($fixture->odds_1 && $fixture->odds_X && $fixture->odds_2) {
            switch ($fixture->tip) {
                case '1X':
                    $fixture->percentage = $odds_1 + $odds_X;
                    break;
                case 'X2':
                    $fixture->percentage = $odds_X + $odds_2;
                    break;
                case '12':
                    $fixture->percentage = $odds_2 + $odds_1;
                    break;
            }
        } else {
            $fixture->percentage = null;
        }
    }

    private function setTeamLogos($fixture)
    {
        $lowercaseHomeTeam = strtolower($fixture->home_team);
        $lowercaseAwayTeam = strtolower($fixture->away_team);
        $formattedHomeTeam = str_replace(' ', '_', $lowercaseHomeTeam);
        $formattedAwayTeam = str_replace(' ', '_', $lowercaseAwayTeam);
        $fixture->home_team_logo_url = '/assets/img/' . $formattedHomeTeam . '.png';
        $fixture->away_team_logo_url = '/assets/img/' . $formattedAwayTeam . '.png';
    }


}
