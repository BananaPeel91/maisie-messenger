<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| This is where you register API routes for your application.
| The route is protected by API key authentication.
|
*/

Route::middleware('api.key')->group(function () {
    Route::post('/send-love', [MessageController::class, 'sendLove']);
});

