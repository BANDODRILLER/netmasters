<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scores extends Model
{
    protected $fillable = ['date', 'time', 'home_team', 'away_team', 'score','league_name'];

}
