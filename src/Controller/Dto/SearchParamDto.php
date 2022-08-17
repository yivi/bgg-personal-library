<?php

declare(strict_types=1);

namespace App\Controller\Dto;

class SearchParamDto
{

    public function __construct(
        public readonly ?string $gameName = null,
        public readonly ?int $playerCount = null,
        public readonly ?int $exactPlayerCount = null,
        public readonly ?int $minPlaytime = null,
        public readonly ?int $maxPlaytime = null,
        public readonly ?float $minWeight = null,
        public readonly ?float $maxWeight = null,
        public readonly ?int $recommendedAge = null
    ) {
    }

}
