<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;

class AboutUsController extends Controller
{
    /**
     * GET /api/about
     * Возвращает первую (единственную) запись "О нас"
     */
    public function index()
    {
        $about = AboutUs::first();
        return response()->json($about);
    }
}