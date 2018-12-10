<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challeng_item extends Model
{
    public function challenges()
    {
        return $this->hasMany('App\Challege', 'id', 'challenge_id');
    }
}
