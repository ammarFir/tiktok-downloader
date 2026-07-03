<?php

use App\Http\Controllers\TikTokController;
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

Route::get('/', [TikTokController::class, 'index'])->name('home');
Route::post('/download', [TikTokController::class, 'process'])->name('download.process');
Route::get('/download/stream', [TikTokController::class, 'stream'])->name('download.stream');
