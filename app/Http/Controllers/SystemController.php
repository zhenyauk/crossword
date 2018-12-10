<?php

namespace App\Http\Controllers;

use App\Alert;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function alertProblems( Request $request )
    {
        $message = $request->message;

        if ( !($device_id = $request->device_id) ){
            $device_id = '';
        }

        if( !($user_id = $this->getUid()) ){
            $user_id = '';
        }

        $alert = new Alert;
        $alert->message = $message;
        $alert->user_id = $user_id;
        $alert->device_id = $device_id;
        $alert->save();
        return ['message'=>'ok'];
    }

    public function getAllAlerts()
    {
        return Alert::all();
    }


}
