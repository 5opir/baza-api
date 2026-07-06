<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commercial;
use Illuminate\Http\Request;

class CommercialController extends Controller
{
    /**
     * GET /api/commercials?category=advertising
     */
    public function index(Request $request)
    {
        $query = Commercial::query();

        if ($category = $request->get('category')) {
            $query->where('category', $category);
        }

        return response()->json($query->get());
    }
}