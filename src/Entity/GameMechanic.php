<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table('game_mechanics')]
class GameMechanic
{

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'string')]
        public readonly string $name)
    {
    }

}