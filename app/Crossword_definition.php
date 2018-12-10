<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Crossword;
class Crossword_definition extends Model
{

    public function crosswords()
    {
        return $this->belongsTo('App\Crossword');
    }
}
