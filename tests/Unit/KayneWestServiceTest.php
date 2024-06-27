<?php

namespace Tests\Unit;

use App\Services\KayneWestService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class KayneWestServiceTest extends TestCase
{
    private KayneWestService $sut;

    private array $fakeQuotes = [
        'Quote 1', 'Quote 2', 'Quote 3', 'Quote 4', 'Quote 5',
        'Quote 6', 'Quote 7', 'Quote 8', 'Quote 9', 'Quote 10',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake([
            'https://api.kanye.rest/quotes' => Http::sequence()
                ->push($this->fakeQuotes)
                ->push(['Quote 11']),
        ])->preventStrayRequests();

        $this->sut = new KayneWestService();
    }

    public function testGetQuotesOnlyCallTheApiOnce(): void
    {
        $this->sut->getQuotes();
        $this->sut->getQuotes();

        Http::assertSentCount(1);
    }

    public function testGetQuotesCachesTheQuotes(): void
    {
        $this->assertFalse(Cache::has(KayneWestService::CACHE_KEY));

        $this->sut->getQuotes();

        $this->assertTrue(Cache::has(KayneWestService::CACHE_KEY));
    }

    public function testGetQuotesShufflesTheQuotes(): void
    {
        $this->sut->getQuotes();

        $quotes = Cache::get(KayneWestService::CACHE_KEY);

        $this->assertIsArray($quotes);
        $this->assertCount(10, $quotes);
        $this->assertNotSame($quotes, $this->fakeQuotes);
        foreach ($this->fakeQuotes as $fakeQuote) {
            $this->assertContains($fakeQuote, $quotes);
        }
    }

    public function testRefreshQuotesClearsTheCache(): void
    {
        $this->sut->getQuotes();
        $this->assertCount(10, Cache::get(KayneWestService::CACHE_KEY));

        $this->sut->refreshQuotes();
        $this->assertCount(1, Cache::get(KayneWestService::CACHE_KEY));
    }
}
