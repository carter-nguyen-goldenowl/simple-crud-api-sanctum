<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\AuthController;
use App\Models\contacts;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/contacts', function (){
//    return contacts::all();
//});



//Route::resource('contacts', ContactsController::class);
Route::get('/contacts',[ContactsController::class, 'index']);
Route::get('/contacts/{id}',[ContactsController::class, 'show']);
Route::get('contacts/search/{name}',[ContactsController::class,'search']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('/contacts', [ContactsController::class, 'store']);
    Route::put('/contacts/{id}',[ContactsController::class,'update']);
    Route::delete('/contacts/{id}',[ContactsController::class, 'destroy']);
    Route::post('/logout',[AuthController::class,'logout']);
});

//Route::put('contacts/{id}',[ContactsController::class,'update']);
