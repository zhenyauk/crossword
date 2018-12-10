<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Crossword;

class Relax_game extends Model
{
    public function Crosswords()
    {
        return $this->belongsTo('App\Crossword');
    }

    public function Users()
    {
        return $this->belongsTo('App\User');
    }
}
