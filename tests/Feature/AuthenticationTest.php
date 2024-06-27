<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public static function urlProvider(): array
    {
        return [
            'Quote API' => ['api/quotes'],
            'Refresh API' => ['api/refresh'],
        ];
    }

    #[Test]
    #[DataProvider('urlProvider')]
    public function it_needs_the_proper_header(string $url): void
    {
        $this->getJson($url)
            ->dumpHeaders()
            ->dump()
            ->assertUnauthorized();
    }

    #[Test]
    #[DataProvider('urlProvider')]
    public function it_needs_a_valid_token(string $url): void
    {
        $this->getJson($url, ['X-API-Token' => 'invalid_token'])
            ->assertUnauthorized();
    }
}
