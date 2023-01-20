<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register','AuthController@register');
Route::post('login','AuthController@login');


Route::middleware('auth:api')->group(function(){
    Route::post('posts/store','PostController@store');
    Route::get('posts/show/{id}','PostController@show');
    Route::put('posts/update/{id}','PostController@update');
    Route::delete('posts/destroy/{id}','PostController@destroy');

    Route::post('comments/store/{post_id}','CommentController@store');
    Route::get('comments/show/{post_id}','CommentController@show');
    Route::put('comments/update/{id}','CommentController@update');
    Route::delete('comments/destroy/{id}','CommentController@destroy');

});
Route::get('posts/index','PostController@index');

