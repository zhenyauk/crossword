<?php

namespace App\Transformers;

use App\Invintation;
use League\Fractal\TransformerAbstract;
use App\User;

class InviteTransform extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {

        $invintation = $user->invintation;
        $invintation_id = null;
        $invintation_n = null;

        $i = 0;
        foreach ($invintation as $item){
            $invintation_n[$i] = $item->name;
            $invintation_id[$i] = $item->id;
            $i++;
        }

    if( isset($invintation_n) and isset($invintation_id) ){}
        return [
            'user'=>$user->id,
            'email'=>$user->email,
            'name'=>$user->name,
            'nickname'=>$user->nickname,
            'points'=>$user->level_points,
            // 'invintation_names' => $invintation_n,
            'invintation_id' => $invintation_id,
        ];
    }
}
