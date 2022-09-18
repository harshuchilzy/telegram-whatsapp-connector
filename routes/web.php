<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});



Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function(){
    
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('profile', [\App\Http\Controllers\UserController::class, 'profile'])->name('user.profile');

    Route::post('/tokens/create', function (Request $request) {
        $token = $request->user()->createToken($request->token_name);
        return ['token' => $token->plainTextToken];
    })->name('user.token.create');

    Route::get('telegram', [\App\Http\Controllers\TelegramController::class, 'initClient'])->name('telegram.dashboard');
    Route::get('telegram/settings', [\App\Http\Controllers\TelegramController::class, 'settings'])->name('telegram.settings');
    Route::post('telegram/settings', [\App\Http\Controllers\TelegramController::class, 'storeSettings'])->name('telegram.settings.store');

    Route::post('/session/store', [\App\Http\Controllers\UserController::class, 'authSessionKeys'])->name('store.sessions');

    Route::get('inbox', [\App\Http\Controllers\API\MessageController::class, 'inbox'])->name('inbox');

    // Connect with Servers
    Route::get('/servers', [\App\Http\Controllers\FrontendController::class, 'authenticateServers'])->name('servers.connect');

    // FIlters/Parsers
    Route::resource('filters', \App\Http\Controllers\FilterController::class);
    // Settings
    Route::get('settings', [\App\Http\Controllers\SettingsController::class, 'settings'])->name('settings');
    Route::post('settings', [\App\Http\Controllers\SettingsController::class, 'store'])->name('settings.store');

    // Forward to Whatsapp
    // Route::post('whatsapp-this', [\App\Http\Controllers\API\WhatsappController::class, 'sendWhatsapp'])->name('whatsapp.this');
    // Test Location
    Route::get('test', [\App\Http\Controllers\API\TelegramController::class, 'test']);

});



require __DIR__.'/auth.php'; 