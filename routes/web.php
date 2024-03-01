<?php

use App\Http\Controllers\FootballController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\LeaguesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[HomePageController::class, 'index'])->name('index');
Route::get('/get-updated-scores', [HomePageController::class, 'getUpdatedScores'])->name('get.updated.scores');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/overunder', [HomePageController::class, 'overunder'])->name('overunder');
Route::get('detail', [HomePageController::class, 'matchdetails']);
Route::get('/htft', [HomePageController::class, 'htft']);
Route::get('/both', [HomePageController::class, 'both']);
Route::get('/handicap', [HomePageController::class, 'handicap']);
Route::get('/corner', [HomePageController::class, 'corner']);
Route::get('/overtwo', [HomePageController::class, 'overtwo']);
Route::get('/scores', [HomePageController::class, 'scores']);
Route::get('gametime', [HomePageController::class, 'gametime']);
Route::get('/leagues', [FootballController::class, 'getLeagues'])->name('leagues');
Route::get('/pickofday', [HomePageController::class, 'pickofday']);
Route::get('/probability', [HomePageController::class, 'probability']);
Route::get('/cs1', [HomePageController::class, 'cs1']);
Route::get('/over1', [HomePageController::class, 'over1']);
Route::get('/over2', [HomePageController::class, 'over2']);
Route::get('/fetch-league-matches', [LeaguesController::class, 'fetchLeagueMatches']);
Route::get('/tables',[LeaguesController::class, 'tables'])->name('tables');
Route::get('search', [HomePageController::class, 'search'])->name('search');
Route::get('/date', [HomePageController::class, 'date'])->name('date');
Route::get('double', [HomePageController::class, 'double'])->name('double');
Route::get('/percentages', [HomePageController::class, 'percentages'])->name('percentages');
Route::get('/percentagedate', [HomePageController::class, 'percentagedate'])->name('percentagedate');
Route::get('doubledate', [HomePageController::class, 'doubledate'])->name('doubledate');
Route::get('/matchdetails', [HomePageController::class, 'matchdetails'])->name('matchdetails');



Route::get('/test' , function()
{
    dd(phpinfo());
});






