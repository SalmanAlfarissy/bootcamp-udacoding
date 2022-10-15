<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Category2Controller;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LandingpageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/',function(){
//     return view('welcome');
// });


Route::get('/test',function(){
    return 'test';
})->middleware(['checkLevel:ADMIN,USER']);

Route::get('/login',[LoginController::class,'index'])->name('login');
Route::get('/',[LandingpageController::class,'index'])->name('index');



Route::get('/hash-make',function(){
return Hash::make('123123');
});

Route::post('/auth-login',[LoginController::class,'Login'])->name('auth-login');

Route::get('/register',[LoginController::class,'register'])->name('register');
Route::post('/storeRegist',[LoginController::class,'storeRegist'])->name('storeRegist');


Route::get('/logout', function(){
    Auth::logout();
    return redirect('/login');
});

Route::middleware(['checkLevel:ADMIN,USER','auth'])->group(function(){
    Route::prefix('/category')->group(function(){
        Route::get('/', [CategoryController::class,'index']);
        Route::get('/create', [CategoryController::class,'create']);
        Route::get('/edit/{id}', [CategoryController::class,'edit']);
        Route::post('/destroy/{id}', [CategoryController::class,'destroy']);
        Route::post('/store', [CategoryController::class,'store']);
        Route::post('/update/{id}', [CategoryController::class,'update']);
        // Route::get('/delete/{id}', [CategoryController::class,'delete']);
        Route::get('/search', [CategoryController::class,'search']);
    });

    Route::prefix('/category2')->group(function(){
        Route::get('/', [Category2Controller::class,'index']);
        Route::get('/getdata', [Category2Controller::class,'getData']);
        Route::post('/createdata', [Category2Controller::class,'createData']);
        Route::post('/updatedata/{id}', [Category2Controller::class,'updateData']);
        Route::post('/deletedata/{id}', [Category2Controller::class,'deleteData']);
        Route::post('/updateStatus/{id}', [Category2Controller::class,'updateStatus']);

    });

    Route::prefix('/comment')->group(function(){
        Route::get('/', [CommentController::class,'index']);
        Route::get('/getdata', [CommentController::class,'getData']);
        Route::post('/createdata', [CommentController::class,'createData']);
        Route::post('/updatedata/{id}', [CommentController::class,'updateData']);
        Route::post('/deletedata/{id}', [CommentController::class,'deleteData']);
        Route::get('/getDataTrash', [CommentController::class,'getDataTrash']);
        Route::get('/trash', [CommentController::class,'trash']);
        Route::post('/restoreData/{id}', [CommentController::class,'restoreData']);
        Route::post('/deleteTrash/{id}', [CommentController::class,'deleteTrash']);
    });

    Route::prefix('/news')->group(function(){
        Route::get('/', [NewsController::class,'index']);
        Route::get('/getdata', [NewsController::class,'getData']);
        Route::post('/createdata', [NewsController::class,'createData']);
        Route::post('/updatedata/{id}', [NewsController::class,'updateData']);
        Route::post('/deletedata/{id}', [NewsController::class,'deleteData']);
        Route::get('/getDataTrash', [NewsController::class,'getDataTrash']);
        Route::get('/trash', [NewsController::class,'trash']);
        Route::post('/restoreData/{id}', [NewsController::class,'restoreData']);
        Route::post('/deleteTrash/{id}', [NewsController::class,'deleteTrash']);
    });

    Route::prefix('/profile')->group(function(){
        Route::get('/', [ProfileController::class,'index']);
        Route::get('/getDataProfile', [ProfileController::class,'getDataProfile']);
        Route::post('/updateProfile', [ProfileController::class,'updateProfile']);
        Route::post('/updatePassword', [ProfileController::class,'updatePassword']);

    });

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dash');
    Route::get('/modulus', function () {
        $detik = 5400;
        $jam = $detik / 3600;
        $sisa = $detik%3600;
        $menit = $sisa / 60;
        $detik = $sisa % 60;
        return (int)$jam." jam ".(int)$menit." menit ".$detik." detik ";


    });

});



