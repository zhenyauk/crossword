<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Friendship;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '*'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function friends()
    {
        return $this->belongsToMany('App\User', 'friend_user', 'user_id', 'friend_id')->orWhere('friend_id', $this->id);
    }

    public function invintation()
    {
        return $this->belongsToMany('App\User', 'invintations', 'user_id', 'friend_id')
            //->orWhere('friend_id', $this->id)
            ;
    }

    public function progress()
    {
        return $this->hasMany(GameSave::class);
    }

}
