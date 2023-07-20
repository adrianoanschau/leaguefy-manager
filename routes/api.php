<?php

use Illuminate\Support\Facades\Route;
use Leaguefy\LeaguefyManager\Controllers;

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

Route::apiResource('/games', Controllers\GamesController::class);
Route::apiResource('/teams', Controllers\TeamsController::class);
Route::apiResource('/tournaments', Controllers\TournamentsController::class);
