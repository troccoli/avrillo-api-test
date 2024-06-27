<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class UserBuilder extends Builder
{
    public function whereApiToken(string $token): Builder
    {
        $this->query->where('api_token', $token);

        return $this;
    }
}
