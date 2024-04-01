<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RosterController;

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

Route::get('/upload', [RosterController::class,'showUploadForm'])->name('upload.form');


Route::post('/upload', [RosterController::class,'upload'])->name('upload');
Route::get('/activities', [RosterController::class,'showActivities'])->name('activities');