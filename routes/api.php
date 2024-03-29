<?php

use App\Http\Controllers\API\ClubController;
use App\Http\Controllers\API\PlayerController;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource("players", PlayerController::class);
Route::apiResource("clubs", ClubController::class);
