<?php

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

use App\Http\Controllers\BotManController;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/botman',[BotManController::class, 'handle']);

Route::get('/botman/chat', function () {
   return view('chat');
});

Route::get('/ticket/{ticket}', [TicketController::class, 'show']);
