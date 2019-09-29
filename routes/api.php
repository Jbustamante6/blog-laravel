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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => 'cors'],function(){
    Route::post('login','Auth@Auth');
    Route::get('post', 'PostController@index');
    Route::get('post/{id}', 'PostController@show');
    Route::group(['middleware'=> 'jwt.auth'], function () {
        Route::prefix('admin')->group(function () {
            Route::resources([
                'user' => 'UserController',
                'post' => 'PostController',
                'tag' => 'TagController',
            ]);
        });
    });
});