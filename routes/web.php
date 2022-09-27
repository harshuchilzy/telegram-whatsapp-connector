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
    
    Route::get('/', [\App\Http\Controllers\FrontendController::class, 'dashboard'])->name('dashboard');
    Route::get('/ig-accounts', [\App\Http\Controllers\FrontendController::class, 'fetchAccounts'])->name('dashboard.ig.accounts');
    Route::get('/ig-account/trade/{path}', [\App\Http\Controllers\FrontendController::class, 'fetchCurrentTrades'])->name('dashboard.ig.history');



    Route::get('/messages', [\App\Http\Controllers\FrontendController::class, 'messages'])->name('messages');

    Route::get('profile', [\App\Http\Controllers\UserController::class, 'profile'])->name('user.profile');
    Route::put('profile_update', [\App\Http\Controllers\UserController::class, 'update'])->name('user.profile.update');

    Route::post('/tokens/generate', function (Request $request) {
        $token = $request->user()->createToken($request->token_name);
        return response()->json($token->plainTextToken);
    })->name('user.token.generate');

    Route::get('telegram', [\App\Http\Controllers\TelegramController::class, 'initClient'])->name('telegram.dashboard');
    Route::get('telegram/settings', [\App\Http\Controllers\TelegramController::class, 'settings'])->name('telegram.settings');
    Route::post('telegram/settings', [\App\Http\Controllers\TelegramController::class, 'storeSettings'])->name('telegram.settings.store');

    Route::post('/session/store', [\App\Http\Controllers\UserController::class, 'authSessionKeys'])->name('store.sessions');

    Route::get('inbox', [\App\Http\Controllers\API\MessageController::class, 'inbox'])->name('inbox');

    // Connect with Servers
    Route::get('/servers', [\App\Http\Controllers\FrontendController::class, 'authenticateServers'])->name('servers.connect');
    Route::get('/details_servers', [\App\Http\Controllers\FrontendController::class, 'userDetails'])->name('servers.details');


    // FIlters/Parsers
    Route::resource('filters', \App\Http\Controllers\FilterController::class);
    Route::get('/create/trading', [\App\Http\Controllers\FilterController::class, 'createTradingFilter'])->name('filters.trading');
    Route::get('/create/currency', [\App\Http\Controllers\FilterController::class, 'createCurrencyFilter'])->name('filters.currency');

    // Settings
    Route::get('settings', [\App\Http\Controllers\SettingsController::class, 'settings'])->name('settings');
    Route::post('settings', [\App\Http\Controllers\SettingsController::class, 'store'])->name('settings.store');

    // Forward to Whatsapp
    // Route::post('whatsapp-this', [\App\Http\Controllers\API\WhatsappController::class, 'sendWhatsapp'])->name('whatsapp.this');
    // Test Location
    Route::get('test', [\App\Http\Controllers\API\TelegramController::class, 'test']);

    Route::resource('action', \App\Http\Controllers\ActionController::class);

    Route::get('/history', [\App\Http\Controllers\FrontendController::class, 'history'])->name('account.history');
    Route::post('/fetch-history', [\App\Http\Controllers\FrontendController::class, 'fetchHistory'])->name('account.history.fetch');
});



require __DIR__.'/auth.php'; 