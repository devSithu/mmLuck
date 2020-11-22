<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\APIKeyHandler;

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

Route::group([ 'prefix'=>'auth' , 'namespace'=>'Auth' ],function(){
    Route::post('register','AuthRegisterController@register');
    Route::post('login','AuthRegisterController@login');   
});

Route::middleware('auth:api')->get('getAll',function(){
    return User::all();
});

