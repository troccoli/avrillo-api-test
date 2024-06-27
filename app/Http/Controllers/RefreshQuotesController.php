<?php

namespace App\Http\Controllers;

use App\Contracts\KayneWestServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RefreshQuotesController extends Controller
{
    public function __invoke(Request $request, KayneWestServiceInterface $service): JsonResponse
    {
        $quotes = $service->refreshQuotes();

        return response()->json(array_slice($quotes, 0, 5));
    }
}
