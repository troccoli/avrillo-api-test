<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    private array $fakeQuotes = [
        'Quote 1', 'Quote 2', 'Quote 3', 'Quote 4', 'Quote 5',
        'Quote 6', 'Quote 7', 'Quote 8', 'Quote 9', 'Quote 10',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake([
            'https://api.kanye.rest/quotes' => Http::response($this->fakeQuotes),
        ])->preventStrayRequests();

        User::factory()->withApiToken('API-TOKEN')->create();
        $this->withHeader('X-API-Token', 'API-TOKEN');
    }

    #[Test]
    public function it_gets_the_first_five_quotes(): void
    {
        $this->getJson(route('api.quotes'))
            ->assertOk()
            ->assertJsonCount(5);
    }

    #[Test]
    public function it_returns_the_same_quotes_over_multiple_calls(): void
    {
        $quotes = $this->getJson(route('api.quotes'))
            ->json();

        $this->getJson(route('api.quotes'))
            ->assertJson($quotes);
    }

    #[Test]
    public function it_can_refresh_the_quotes(): void
    {
        $this->getJson(route('api.refresh'))
            ->assertOk()
            ->assertJsonCount(5);
    }

    #[Test]
    public function the_refresh_returns_different_quotes(): void
    {
        $quotes = $this->getJson(route('api.quotes'))
            ->json();
        $refreshedQuotes = $this->getJson(route('api.refresh'))
            ->json();

        $this->assertNotSame($refreshedQuotes, $quotes);
    }
}
