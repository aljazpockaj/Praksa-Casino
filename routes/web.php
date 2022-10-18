<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BetController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MoneyController;
use App\Http\Controllers\SeamlessGameController;
use GuzzleHttp\Client;
/*
|-------------------------------------- ------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) 

Route::get('/bets', [BetController::class, 'GetData']);
*/

Route::get('/', [GameController::class, 'getGame']);
Route::get('/game', [GameController::class, 'Game']);
Route::get('/opengame', [GameController::class, 'openGame']);
Route::get('/api/seamless', [SeamlessGameController::class, 'index']);
Route::any('/login', [LoginController::class, 'data']);
Route::get('/create', function () {
    return view('createplayer');
});
Route::any('money',[MoneyController::class, 'money']);
Route::any('/fillDB',[GameController::class, 'getGameList']);
?>