<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use Illuminate\Http\Request;
use App\Services\PackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class PackController extends Controller
{
    public function buy(Request $request, PackService $service): JsonResponse
    {
        $quantity = $request->get('quantity');
        
        try {
            $validated = $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);

            return response()->json([
                'packs' => $service->calculatePacks($quantity)
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
