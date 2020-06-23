<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tables extends Model
{
    protected $fillable = [
        'players_id', 'total_players', 'boot_value', 'pot_limit', 'current_value', 'real_players'
    ];
}