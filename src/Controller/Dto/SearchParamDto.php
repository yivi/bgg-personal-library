<?php

declare(strict_types=1);

namespace App\Controller\Dto;

class SearchParamDto
{

    public function __construct(
        public readonly string $gameName = '',
        public readonly int $playerCount = 0,
        public readonly bool $exactPlayerCount = false,
        public readonly int $playtime = 0,
        public readonly bool $minPlaytime = false,
        public readonly float $weight = 0,
        public readonly int $minAge = 0
    ) {
    }

}
