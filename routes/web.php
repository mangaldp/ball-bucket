<?php

use App\Http\Controllers\BallController;
use App\Http\Controllers\BucketController;
use App\Http\Controllers\OptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('result.add');
});

// Bucket Controller Routes
Route::get('/bucket',[BucketController::class,'index'])->name('bucket.list');
Route::get('/bucket/add',[BucketController::class,'add'])->name('bucket.add');
Route::post('/bucket/store',[BucketController::class,'store'])->name('bucket.store');
Route::get('/bucket/edit/{bucket}',[BucketController::class,'edit'])->name('bucket.edit');
Route::put('/bucket/update/{bucket}',[BucketController::class,'update'])->name('bucket.update');
Route::get('/bucket/delete/{bucket}',[BucketController::class,'delete'])->name('bucket.delete');

// Ball Controller Routes
Route::get('/ball',[BallController::class,'index'])->name('ball.list');
Route::get('/ball/add',[BallController::class,'add'])->name('ball.add');
Route::post('/ball/store',[BallController::class,'store'])->name('ball.store');
Route::get('/ball/edit/{ball}',[BallController::class,'edit'])->name('ball.edit');
Route::put('/ball/update/{ball}',[BallController::class,'update'])->name('ball.update');
Route::get('/ball/delete/{ball}',[BallController::class,'delete'])->name('ball.delete');

// Option Controller Routes
Route::get('/result',[OptionController::class,'index'])->name('result.list');
Route::get('/result/add',[OptionController::class,'add'])->name('result.add');
Route::post('/result/calculate',[OptionController::class,'calculate'])->name('result.calculate');
Route::post('/result/store',[OptionController::class,'store'])->name('result.store');
Route::get('/result/show/{option}',[OptionController::class,'show'])->name('result.show');
Route::get('/result/delete/{option}',[OptionController::class,'delete'])->name('result.delete');