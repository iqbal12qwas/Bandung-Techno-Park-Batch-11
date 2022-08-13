<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ActivityController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// VIEW
Route::get('data.index', [IndexController::class, 'indexPaginate'])->name('activities.list');

Route::get('/', [IndexController::class,'index']);
Route::get('/activity', [ActivityController::class,'index']);
Route::get('/create', [IndexController::class,'create']);

// DATA
Route::get('/month', [IndexController::class,'getMonth']);
Route::get('/method', [IndexController::class,'getMethod']);

// CRUD
// List Table
Route::get('/read',[IndexController::class,'read']);
Route::get('/paginate',[IndexController::class,'paginate']);
Route::post('/store', [IndexController::class,'store']);
Route::get('/show/{id}',[IndexController::class,'show']);
Route::patch('/update/{id}',[IndexController::class,'update']);
Route::delete('/delete/{id}',[IndexController::class,'delete']);

// Activity
Route::get('/activity_list',[ActivityController::class,'activityList']);
Route::get('/count_month',[ActivityController::class,'getCountMonth']);
Route::get('/count_method',[ActivityController::class,'getCountMethod']);