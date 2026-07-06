<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * GET /api/films?type=fiction
     * Список всех фильмов, опционально с фильтром по типу
     */
    public function index(Request $request)
    {
        $query = Film::query();

        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }

        return response()->json($query->get());
    }

    /**
     * GET /api/films/{id}
     * Один фильм с титрами
     */
    public function show(Film $film)
    {
        // Подгружаем титры одним запросом
        $film->load('credits');
        return response()->json($film);
    }
}