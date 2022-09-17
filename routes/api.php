<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('incoming-message', [\App\Http\Controllers\API\MessageController::class, 'incomingMessage'])->middleware('auth:sanctum')->name('api.incoming-telegram');

Route::post('whatsapp-qr', [\App\Http\Controllers\API\WhatsappController::class, 'receiveQR'])->middleware('auth:sanctum');

Route::post('whatsapp-webhook', [\App\Http\Controllers\API\WhatsappController::class, 'webhook'])->middleware('auth:sanctum');
Route::post('telegram-webhook', [\App\Http\Controllers\API\TelegramController::class, 'webhook'])->middleware('auth:sanctum');
