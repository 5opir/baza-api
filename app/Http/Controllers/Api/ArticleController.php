<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * GET /api/articles
     */
    public function index()
    {
        return response()->json(Article::all());
    }
}