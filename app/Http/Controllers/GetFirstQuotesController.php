<?php

namespace App\Http\Controllers;

use App\Contracts\KayneWestServiceInterface;
use App\Services\KayneWestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetFirstQuotesController extends Controller
{
    /**
     * @param  KayneWestService  $service
     */
    public function __invoke(Request $request, KayneWestServiceInterface $service): JsonResponse
    {
        $quotes = $service->getQuotes();

        return response()->json(array_slice($quotes, 0, 5));
    }
}
