<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FilmController;
use App\Http\Controllers\Api\CommercialController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| Публичные API-маршруты киностудии БАЗА
|--------------------------------------------------------------------------
*/

// Кино и сериалы
Route::get('/films',        [FilmController::class, 'index']);
Route::get('/films/{film}', [FilmController::class, 'show']);

// Реклама, клипы, reels
Route::get('/commercials', [CommercialController::class, 'index']);

// Пресса
Route::get('/articles', [ArticleController::class, 'index']);

// Страница "О нас"
Route::get('/about', [AboutUsController::class, 'index']);

// Заявки на съёмку
Route::post('/orders', [OrderController::class, 'store']);