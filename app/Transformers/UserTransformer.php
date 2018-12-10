<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user, $token = true)
    {
        return [
            'username' => $user->name,
            'password' => $user->password,
            'token'    => $user->token,
            'message'  => "Thank you for registration!"
        ];
    }
}
