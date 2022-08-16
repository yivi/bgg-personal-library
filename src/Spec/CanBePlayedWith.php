<?php

declare(strict_types=1);

namespace App\Spec;

use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Spec;
use Happyr\DoctrineSpecification\Specification\BaseSpecification;

final class CanBePlayedWith extends BaseSpecification
{

    public function __construct(private readonly int $playerCount, ?string $context = null)
    {
        parent::__construct($context);
    }

    public static function c(int $playerCount, ?string $context = null): self
    {
        return new self($playerCount, $context);
    }

    protected function getSpec(): Filter|QueryModifier
    {
        return Spec::andX(
            Spec::gte('maxPlayers', $this->playerCount),
            Spec::lte('minPlayers', $this->playerCount)
        );
    }

}
