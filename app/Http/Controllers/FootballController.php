<?php

namespace App\Http\Controllers;

use App\Models\Leagues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FootballController extends Controller
{
 public function fetchInsert()
 {
     $response = Http::get('http://sports.core.api.espn.com/v2/sports/mma/leagues/ufc/events/600030732');



 }
 public function show()
 {
     $league['data'] = Leagues::all();
     return view('home.leagues',$league);
 }


}
