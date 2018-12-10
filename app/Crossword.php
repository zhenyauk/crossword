<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Crossword_definition;

class Crossword extends Model
{
    protected $table = "crosswords";
    public $save = null;

    protected $fillable = [
        'user_id', 'revision', 'content', 'width','height','level','helps', 'created_at', 'updated_at',
        'difficulty_level', 'goal_time'
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function crossword_definition()
    {
        return $this->hasMany('App\Crossword_definition');
    }

    public function progress()
    {
        return $this->hasOne(GameSave::class,  'game_id', 'id');
    }


}
