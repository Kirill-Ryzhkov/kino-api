<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

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

Route::middleware("auth:api")->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/movies/all/{limit?}/{order?}/{dir?}', [MovieController::class, "getLimited"]);

    Route::get('/movies/year/{year}/{dir?}', [MovieController::class, 'getYear']);

    Route::get('/movies/name/{name}', [MovieController::class, 'getName']);

    Route::get('/movies/genre/{genre}', [MovieController::class, 'getGenre']);

    Route::get('/movies/length/{length}/{dir?}', [MovieController::class, 'getLength']);
});

