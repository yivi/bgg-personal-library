<?php

declare(strict_types=1);

namespace App\Controller\Dto;

class SearchParamDto
{

    public function __construct(
        public ?string $gameName = null,
        public ?int $playerCount = null,
        public ?int $exactPlayerCount = null,
        public ?int $minPlaytime = null,
        public ?int $maxPlaytime = null,
        public ?float $minWeight = null,
        public ?float $maxWeight = null,
        public ?int $recommendedAge = null,
        public ?string $orderBy = 'name',
        public ?string $order = 'ASC'
    ) {
    }

}
