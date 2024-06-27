<?php

namespace App\Contracts;

interface KayneWestServiceInterface
{
    public function getQuotes(): array;

    public function refreshQuotes(): array;
}
