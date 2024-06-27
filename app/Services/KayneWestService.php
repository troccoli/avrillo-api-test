<?php

namespace App\Services;

use App\Contracts\KayneWestServiceInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class KayneWestService implements KayneWestServiceInterface
{
    const CACHE_KEY = 'kayne_west';

    public function getQuotes(): array
    {
        return Cache::remember(
            key: static::CACHE_KEY,
            ttl: today()->endOfDay(),
            callback: function (): array {
                $quotes = Http::get('https://api.kanye.rest/quotes')->json();
                shuffle($quotes);

                return $quotes;
            },
        );
    }

    public function refreshQuotes(): array
    {
        Cache::forget(static::CACHE_KEY);

        return $this->getQuotes();
    }
}
