<?php

use App\Http\Controllers\RequestsController;
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

Route::resource('song-requests', RequestsController::class)->except(['create', 'edit']);
Route::delete('song-requests', [RequestsController::class, 'clear'])->name('song-requests.clear');
