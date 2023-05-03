<?php

use App\Http\Controllers\MapsController;
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

Route::get('/', [MapsController::class, 'home']);
Route::get('/get-loc', [MapsController::class, 'getLoc']);
Route::post('/store', [MapsController::class, 'store']);
