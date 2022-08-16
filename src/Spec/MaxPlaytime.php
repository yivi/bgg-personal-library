<?php

declare(strict_types=1);

namespace App\Spec;

use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Spec;
use Happyr\DoctrineSpecification\Specification\BaseSpecification;

class MaxPlaytime extends BaseSpecification
{

    public function __construct(private readonly int $playtime, ?string $context = null)
    {
        parent::__construct($context);
    }

    public static function c(int $playtime, ?string $context = null): self
    {
        return new self($playtime, $context);
    }

    protected function getSpec(): Filter|QueryModifier
    {
        return Spec::lte('maxPlaytime', $this->playtime);
    }


}
