<?php
use Illuminate\Http\Request;

/**
 * by Eugene. For questions: Zhenyauk@gmail.com
 * All path have `api` prefix,
 * for example not '/users', but '/api/users'
 */

// Registration
Route::post('/registration', 'ApiAuthController@register')->name('register');
//Registration with facebook
Route::post('/fbregister', 'ApiAuthController@registerFacebook')->name('fregister');

// Authorization, send back token (see /config/jwt for more option for token)
Route::post('/auth', ['uses'=>'ApiAuthController@auth'])->name('api_auth');
Route::post('/fblogin', ['uses'=>'ApiAuthController@fbauth'])->name('api_auth');

/** ==========       Only for auth Users          ========== */
Route::group([ 'middleware' => 'jwt.auth'], function(){

    /** ===== USER api ===== */ /** ===== USER api ===== */ /** ===== USER api ===== */ /** ===== USER api ===== */

    //get user full info
    Route::get('/info', 'UserController@getUserInfo');
    //custom user info
    Route::get('/user/{id}', 'UserController@getCustmUserInfo');
    //store User info
    Route::post('/info/store', 'UserController@storeUserInfo');
    //store User info
    Route::post('/user/destroy', 'UserController@destroyUser');
    //Change passowrd post['password']
    Route::post('/password/change', 'UserController@storeUserPassword');
    /** Level */
    //get user level  @int
    Route::get('/level', 'UserController@getUserLevel');
    //set user level $post['level_points']
    Route::post('/level/store', 'UserController@StoreUserLevel');
    /** Online */
    //Get User Online Status @int
    Route::get('/online', 'UserController@getUserOnlineStatus');
    //Set user online status @bool
    Route::get('/online/setonline', 'UserController@storeUserOnline');
    //Set user offline status @bool
    Route::get('/online/setoffline', 'UserController@storeUserOffline');
    //Get all users online @object
    Route::get('/online/getonline', 'UserController@getUsersOnline');
    /** FRIENDS */
    //Get all friens
    Route::get('/friends', 'UserController@getUserFriends');
    //Remove friend
    Route::get('/friends/del/{id}', 'UserController@delUserFriend');
    //Show all ivintations sent by current user
    Route::get('/invite/send', 'UserController@showInvintations');
    //Show who invited me
    Route::get('/invite', 'UserController@showWHoInvitedMe');
    //Send ivintation to user
    Route::get('/invite/{id}', 'UserController@sendInvintation');
    //Agree ivintation
    Route::get('/invite/agree/{id}', 'UserController@agreeInvite');

    Route::get('/invite/declineuser/{uid}', 'UserController@declineInvintationByUserId');
    Route::get('/invite/decline/{id}', 'UserController@declineInvintationById');




    Route::get('/users/all', 'UserController@getAllUsers');

    Route::get('/users/change/{name}', 'UserController@changeName');
    Route::get('/users/change/{name}', 'UserController@changeNickName');
    Route::get('/users/challenge/accept', 'UserController@acceptChallenge');
    Route::get('/users/challenge/disable', 'UserController@dissableChallenge');

    Route::get('/user/updates/{id}/{field}/{data}', 'UserController@superUpdate');
    //restore password
    Route::get('/user/restore/{email_or_nick}', 'UserController@passwordRestore');
    Route::get('/user/password-restore/{token}', 'UserController@UserRestorePassword');

    //Ban
    Route::get('/users/ban/{uid}', 'UserController@userAddToBan');
    Route::get('/users/unban/{uid}', 'UserController@userDelToBan');
    Route::get('/users/banlist', 'UserController@banList');







    /** ===== GAME api ===== */ /** ===== GAME api ===== */ /** ===== GAME api ===== */

    Route::post('/game/save', 'GameController@storeLastGame');
    Route::get('/puzzles_list/{id}', 'GameController@getPuzzle');
    Route::get('/puzzles_list/', 'GameController@getAllPuzzles');
    Route::get('/puzzles_list/level/{id}', 'GameController@getLevelPuzzles');
    Route::get('/puzzles_list/relax', 'GameController@getRelaxPuzzles');


    Route::get('/game/random', 'GameController@getRandom');
    Route::get('/challenge/random', 'GameController@getRandomChallenge');
    // when useer deny request
    Route::get('/challenge/deny/{deny_challenge}', 'GameController@deny_challenge');

    //statistick
    Route::get('game/statistic', 'GameController@getUserFullStatistic');
    Route::get('game/statistic/level/{cid}', 'GameController@getLevelStatistic');
    Route::post('game/statistic/store', 'GameController@storeUserStatistic');
    Route::get('game/statistic/top/{top}', 'GameController@getTopStatistic');

    //get all User's chellanges
    Route::get('challenges/get', 'GameController@getChallanges');
    //The same but with random game
    Route::get('challenges/invite/{uid}/', 'GameController@setChellangeWithRandomMap');
    //Invite someone to chellange - uid - user_id whom invite, cid - crossword_id
    Route::get('challenges/invite/{uid}/{cid}', 'GameController@setChellange');

    //update any parameter of challemge.
    // {id} - challenge_id (can get in '/api/challeges/get'),
    // {what} - what to change, for example friend_id or crossword_id in challenges
    //{param} -new parametr
    //For example:
    // challenges/update/1/crossword_id/7
    //or next example: challenges/update/1/frine_id/5


    Route::get('challenge/update/points/{points}', 'GameController@updateUserPoints');
    Route::get('challenge/update/points/{friend_id}/{friend_points}', 'GameController@updateFriendsPoints');
    Route::get('challenge/update/points/{current_user_points}/{friend_id}/{friend_points}', 'GameController@updateUserFriendsPoints');

    Route::get('challenges/updates/{ch_id}/{uid}/{points}', 'GameController@updateChallengePoints');
    Route::get('challenges/start', 'GameController@challengeStart');
    Route::post('challenges/save/', 'GameController@challengeSave');
    Route::get('challenges/load/{id}', 'GameController@challengeLoad');
    //Finish challenge and find winner

    Route::post('challenges/{id}/finish', 'GameController@challengeFinish');

    //Update many fields. {['id'=>5, 'title'=>'some_title']}
    Route::get('challenges/update/{id}/{what_and_param}', 'GameController@updateChellange');
    Route::get('challenges/update-many/{id}/{what}/{param}', 'GameController@updateManyChellange');
    Route::post('puzzles/save/', 'GameController@gameSave');
    Route::get('puzzles/load/{id}', 'GameController@gameLoad');
    //Time left for accept new request. By default 40 seconds. Can change here
    Route::get('challenges_get/{time}', 'GameController@timeLeftChallenge');


    /*
     *
     *      SYSTEM FUNCTIONS
    */

    Route::post('trouble-alert', 'GameController@alertProblems');



});