<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateApiUser extends Command
{
    /** @var string */
    protected $signature = 'app:create-api-user';

    /** @var string */
    protected $description = 'Creates a user that can be used to call the APIs.';

    public function handle(): int
    {
        $user = User::factory()->create();

        $this->info("The user's API Token is: ".$user->api_token);

        return Command::SUCCESS;
    }
}
