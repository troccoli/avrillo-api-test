<?php

namespace Tests\Feature\Console\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateApiUserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_create_an_user_with_an_api_token(): void
    {
        $this->assertDatabaseEmpty('users');

        $this->artisan('app:create-api-user')
            ->expectsOutputToContain("The user's API Token is:");

        $this->assertDatabaseCount('users', 1);
    }
}
