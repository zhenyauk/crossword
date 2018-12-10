<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class FriendTransform extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        $friends = $user->friends;
        $friends_n =[];
        $friends_id = [];
        $i = 0;
        foreach ($friends as $item){
            $friends_n[$i] = $item->name;
            $friends_id[$i] = $item->id;
            $i++;
        }

        return [
            'user'=>$user->name,
            'friends_names' => $friends_n,
            'friends_id' => $friends_id,
        ];
    }
}
