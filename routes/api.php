<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

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

Route::prefix('/news')->group(function(){
    Route::get('/', [NewsController::class,'index']);
    Route::get('/getdata', [NewsController::class,'getData']);
    Route::post('/createdata', [NewsController::class,'createData']);
    Route::post('/updatedata/{id}', [NewsController::class,'updateData']);
    Route::post('/deletedata/{id}', [NewsController::class,'deleteData']);
});
