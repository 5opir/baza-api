<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * POST /api/orders
     * Создание заявки на съёмку
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'contact'      => 'required|string|max:255',
            'project_type' => 'nullable|string|max:255',
            'description'  => 'nullable|string',
        ]);

        $order = Order::create($validated);

        return response()->json([
            'message' => 'Заявка успешно отправлена',
            'order'   => $order,
        ], 201);
    }
}