<?php

namespace App\Http\Controllers;

use App\Ban;
use App\Friend;
use App\Invintation;
use App\Restore;
use App\Transformers\FriendTransform;
use App\Transformers\InviteTransform;
use App\Transformers\WhoInviteMe;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //get full User info
    public function getUserInfo()
    {
        //This method is in App\Controller
         $user = $this->getUser();
         return $user;
    }

    public function getCustmUserInfo($id)
    {
        $id = $this->secure($id);
        $user = User::where('id', $id)->first();
        return $user;

    }

    public function destroyUser(  )
    {
        $user = $this->getUser();

        if( $user->delete() )
            return "ok";

    }


    //Store User Info
    public function storeUserInfo( Request $request )
    {
        //This method is in App\Controller
        $user = $this->getUser();


        foreach ($request->all() as $key=>$item){
            $user->$key = $item;
        }

        $user->save();
        return response()->json(['message' => "OK"]);
    }

    public function Accaunt( $id, $password )
    {

    }

    public function changeName($name)
    {
        $name = $this->secure($name);
        $user = $this->getUser();
        $user->name = $name;
        $user->save();
        return json_encode(1);

    }

    public function changeNickName($name)
    {
        $name = $this->secure($name);
        $user = $this->getUser();
        $user->nickname = $name;
        $user->save();
        return ['ok'];

    }

    public function acceptChallenge()
    {
        $user = $this->getUser();
        $user->challenges_accept = 1;
        $user->save();
        return json_encode(1);
    }

    public function dissableChallenge()
    {
        $user = $this->getUser();
        $user->challenges_accept = 0;
        $user->save();
        return json_encode(1);
    }

    //change passowrd
    public function storeUserPassword(Request $request)
    {
        $user = $this->getUser();
        if( isset($request->password) and !empty($request->passowrd) ){
            $user->password = bcrypt($request->password);
            return true;
        }
        return false;
    }

    //Store online status
    public function storeUserOnline()
    {
        //This method is in App\Controller
        $user = $this->getUser();
        $user->online = 1;
        $user->save();
        return json_encode(1);
    }

    //Store offline status
    public function storeUserOffline()
    {
        //This method is in App\Controller
        $user = $this->getUser();
        $user->online = 0;
        $user->save();
        return json_encode(1);
    }

    //get current user status
    public function getUserOnlineStatus()
    {
        //This method is in App\Controller
        $user = $this->getUser();
        return json_encode($user->online);
    }

    //Get Status
    public function getUsersOnline()
    {
        //This method is in App\Controller
        $user = $this->getUser();
        $users = User::where('online', 1)->get();
        return $users;
    }

    //Get user level
    public function getUserLevel()
    {
        $user = $this->getUser();
        return $user->level_points;
    }

    //StoreUserLevel
    public function StoreUserLevel(Request $request)
    {
        $user = $this->getUser();
        if( isset($request->level_points) and !empty($request->level_points) ){
            $user->level_points = $request->level_points;
            $user->save();
        }else{
            return false;
        }

        return $user->level_points;
    }

    //Get user's friends
    public function getUserFriends()
    {
        $user = $this->getUser();
        
        return fractal($user, new FriendTransform);
    }

    public function delUserFriend($fid)
    {
        $fid = $this->secure($fid);
        $user = $this->getUid();

        $friend = Friend::where('user_id', $user)->where('friend_id', $fid)->first();
        $friend->delete();
        //delete other side
        $friend = Friend::where('user_id', $fid)->where('friend_id', $user)->first();
        $friend->delete();

        return json_encode(1);

        //return fractal($user, new FriendTransform);
    }

    public function sendInvintation($id)
    {
        $id = $this->secure($id);
        $user = $this->getUid();

        //try if users are already friends
        if( $test = Friend::where('user_id', $user)->where('friend_id', $id)->first() ) return json_encode(["message"=>"already friends"]);
        //try if user didn't send invintation before
        if( $test = Invintation::where('user_id', $user)->where('friend_id', $id)->first() ) return json_encode(["message"=>"already send"]);


        $invite = new Invintation;
        $invite->user_id = $user;
        $invite->friend_id = $id;
        $invite->save();
        return json_encode(["message"=>"ok"]);
    }

    //Show all invintitions
    public function showInvintations()
    {
        $user = $this->getUser();

        return fractal($user, new InviteTransform);

    }
    //Return ID of Users who invited current user
    public function showWHoInvitedMe()
    {
        $user_id = $this->getUid();
        $inv = Invintation::where('friend_id', $user_id)->get();
        $data = [];
        foreach ($inv as $item) {
            $data["user_id"][] = $item->user_id;
            $friend = User::where('id', $item->user_id)->first();

            $data["user_email"][] = $friend->email;
            $data["user_name"][] = $friend->name;
        }
        return json_encode($data);
    }

    //Agree  invintition and become friends
    public function agreeInvite($id)
    {
        $invite_id = $this->secure($id);
        $user_id = $this->getUid();
        $user = $this->getUser();

        if( $friend = Friend::where('user_id', $user_id)->first() ){
            return "already Friends";
        }

        $friend = new Friend;
        $friend->user_id = $user_id;
        $friend->friend_id = $invite_id;
        $friend->save();
        //make double for other side
        $friend = new Friend;
        $friend->user_id = $invite_id;
        $friend->friend_id = $user_id;
        $friend->save();

        //Del invintation
        $invite = Invintation::where('friend_id', $invite_id);
        $invite->delete();

        return json_encode(["message"=>"ok"]);
    }

    public function declineInvintationByUserId( $user_id )
    {
        $user_id = $this->secure($user_id);
        $uid = $this->getUid();
        $invite = Invintation::where('friend_id', $uid)->where('user_id', $user_id)->first();
        $invite->delete();
        return "ok";
    }

    public function declineInvintationById( $id )
    {
        $id = $this->secure($id);
        $invite = Invintation::find($id);
        $invite->delete();
        return "ok";
    }

    public function getAllUsers()
    {
        $users = User::all();
        return $users;
    }

    /*
     * Ban and banlist
     */
    //Add to ban
    public function userAddToBan($uid)
    {
       $uid = $this->secure($uid);
       $user = $this->getUser();

       if( $ban = Ban::where('user_id', $uid)->first() ){
           return "Already banned";
       }
       $ban = new Ban;
       $ban->user_id = $uid;
       $ban->user_name = $user->name;
       $ban->user_nick = $user->nickname;
       if( $ban->save() ){
            return ['uid'=>$uid, 'message'=>'baned'];
       }

    }

    public function userDelToBan($uid)
    {
        $uid = $this->secure($uid);
        if( $ban = Ban::where('user_id', $uid) ){
           if ( $ban->delete() )
              return ['uid'=>$uid, 'message'=>'unbaned'];

        }else{
            return "Already unbaned";
        }

    }


    public function banList()
    {
        $ban = Ban::all();
        return $ban;
    }


    //For generate random string Use in p_restore
    public function RandomString($length) {
        $keys = array_merge(range(0,9), range('a', 'z'));

        $key = "";
        for($i=0; $i < $length; $i++) {
            $key .= $keys[mt_rand(0, count($keys) - 1)];
        }
        return $key;
    }

    public function passwordRestore($email_or_nick)
    {

       // dd ( $this->RandomString(20) );

      if(  $user = User::where('email', $email_or_nick)->first() ){

            $token = $this->RandomString(20);
            //save token to DB
            $restore = new Restore;
            $restore->email = $user->email;
            $restore->token = $user->token;
            $restore->save();


          $message =
              "You got this mail because you want restore your password. Please use this link: "
          . " <a href='/api/user/restore/{$token}'>Restore Link</a> ";

            mb_send_mail($user->email, "Password restore", $message);

            return "Thank you. We sent restore link to  your email: {$user->email}. ";

      }
      elseif( $user = User::where('nickname', $email_or_nick)->first() ){
          dd('nickname');
      }
      return "User with {$email_or_nick} not found";
    }

    public function UserRestorePassword( $token )
    {
       $token = $this->secure($token);
       if ( $restore = Restore::where('token', $token)->where('active', 1)->first() ){
           $password = $this->RandomString(6);
            $user = User::where('email', $restore->email)->first();
            $user->password = $password;
            $user->save();

           $restore->active = 0;
           $restore->save();

           mb_send_mail($user->email, "New password", "Your new password is {$password}  and you can change it when you'll login");

           return "Thank you. Your new password is:  {$password}  and You can change it when you'll login.";
       }

       return "Sorry token was expired.";


    }


    /*
     * Comment in final release
     */
    public function superUpdate($id, $what, $param)
    {
        $id = $this->secure($id);
        $what = $this->secure($what);
        $param = $this->secure($param);

        $user = User::where('id', $id)->first();
        $user->$what = $param;
        $user->save();
        return ['message' => 'ok'];
    }





}
