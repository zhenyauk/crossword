<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegister;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class ApiAuthController extends Controller
{
    /**
     * get token and auth
     * @return \Illuminate\Http\JsonResponse
     */
    public function auth()
    {
        $keys = request()->only('email', 'password');
        $u_email = request()->only('email');


        try{
            //Our token
            $token = JWTAuth::attempt($keys);

            if(!$token){
                return response()->json(['error' => 'wrong email or password'], 401);
            }
        }
        catch (JWTException $e)
        {
            return response()->json(['error'=> 'Ops some thing wrong..'], 500);
        }

        $user = User::where('email', $u_email['email'])->first();
        return response()->json(['token' => $token, 'email'=>$user->email, 'id'=> $user->id ], 200);

    }

    public function fbauth()
    {

        $keys = request()->only('email');
        $u_email = request()->only('email');


        try{
            //Our token


            if( $user = User::where('email', $u_email['email'])->first() ){
                $token = JWTAuth::fromUser($user);
            }else{

                $user = new User;

                $user->email = $u_email['email'];
                $user->name = 'sd';
                $user->password =  bcrypt( 'secret' ) ;

                $user->save() ;

                $token = JWTAuth::fromUser($user);
            }



            if(!$token){
                return response()->json(['error' => 'wrong email or password'], 401);
            }
        }
        catch (JWTException $e)
        {
            return response()->json(['error'=> 'Ops some thing wrong..'], 500);
        }

        $user = User::where('email', $u_email)->first();
        return response()->json(['token' => $token, 'email'=>$user->email, 'id'=> $user->id ], 200);

    }

    /**
     * @param UserRegister $request
     * @return mixed
     */
    public function register(UserRegister $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =  bcrypt( $request->password ) ;
      //  $user->birth_date =  $request->birth_date ;
      //  $user->gender =  $request->gender ;
      //  $user->avatar =  $request->avatar ;

        $user->save() ;

        $token = JWTAuth::fromUser($user);

        $user->token = $token;

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->toArray();

    }

    public function test()
    {
        return $this->getUid();
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        return $user->id;

    }

    public function registerFacebook(Request $request)
    {
        if( $login = User::where('email', $request->email)->first() ){
            $token = JWTAuth::fromUser($login);

            $login->token = $token;

            return fractal()
                ->item($login)
                ->transformWith(new UserTransformer)
                ->toArray();
        }

        $user = new User;
        $user->name =  $request->name;
        $user->email = $request->email;
        $user->password =  bcrypt( 'secret' ) ;

        $user->save() ;
        $token = JWTAuth::fromUser($user);

        $user->token = $token;

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->toArray();
    }

    public function fregister(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $passowrd = $request->name . $request->email . "ksjdf@!n";
        $user->facebook_id = $request->token;
        $user->password =  bcrypt( $passowrd ) ;
        //  $user->birth_date =  $request->birth_date ;
        //  $user->gender =  $request->gender ;
        //  $user->avatar =  $request->avatar ;

        $user->save() ;

        $token = JWTAuth::fromUser($user);

        $user->token = $token;

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->toArray();

    }
}
