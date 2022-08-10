<?php

declare(strict_types=1);


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Game
{

    public function __construct(
        #[ORM\Id]
        #[ORM\Column]
        public readonly int $id,
        #[ORM\Column(type: 'string')]
        public readonly string $name,
        #[ORM\Column(type: 'integer')]
        public readonly int $yearPublished,
        #[ORM\Column(type: 'integer')]
        public readonly int $minPlayers,
        #[ORM\Column(type: 'integer')]
        public readonly int $maxPlayers,
        #[ORM\Column(type: 'integer')]
        public readonly int $minPlaytime,
        #[ORM\Column(type: 'integer')]
        public readonly int $maxPlaytime,
        #[ORM\Column(type: 'integer')]
        public readonly int $minAge,
        #[ORM\Column(type: 'json')]
        public readonly array $categories,
        #[ORM\Column(type: 'json')]
        public readonly array $mechanics,
        #[ORM\Column(type: 'json')]
        public readonly array $designers,
        #[ORM\Column(type: 'string')]
        public readonly string $publisher,
        #[ORM\Column(type: 'float')]
        public readonly float $rating,
        #[ORM\Column(type: 'integer')]
        public readonly int $usersRated,
        #[ORM\Column(type: 'float')]
        public readonly float $averageWeight,
    ) {
    }

}
