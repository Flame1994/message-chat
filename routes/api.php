<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::group(['middleware' => ['allowed']], function() {
//
//});
Route::get('/', function () {
    return view('home');
});

Route::get('/connection', function () {
    try {
        DB::connection()->getPdo();
    } catch (Exception $e) {
        return $e;
    }
    return 'Connection to DB Successful!';
});

Route::group(['prefix' => 'users'], function() {
    Route::get('/', 'UserController@all');
    Route::post('/', 'UserController@create');
    Route::put('/', 'UserController@update');
    Route::get('{id}', 'UserController@show');
    Route::delete('{id}', 'UserController@delete');

    Route::group(['prefix' => '{id}/messages'], function() {
        Route::get('/', 'MessageController@allMessages');
        Route::get('/inc', 'MessageController@allIncomingMessages');
        Route::get('/out', 'MessageController@allOutgoingMessages');
        Route::get('/inc/{from}', 'MessageController@incomingMessagesFrom');
        Route::get('/out/{to}', 'MessageController@outgoingMessagesTo');
        Route::get('/all/{user}', 'MessageController@messagesBetween');
    });
});

Route::group(['prefix' => 'messages'], function() {
    Route::get('/', 'MessageController@all');
    Route::post('/', 'MessageController@create');
    Route::put('/', 'MessageController@update');
    Route::get('{id}', 'MessageController@show');
    Route::delete('{id}', 'MessageController@delete');
});

Route::fallback(function(){
    return response()->json(['message' => 'Not Found.'], 404);
});
