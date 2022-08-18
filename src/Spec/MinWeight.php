<?php

declare(strict_types=1);

namespace App\Spec;

use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Spec;
use Happyr\DoctrineSpecification\Specification\BaseSpecification;

class MinWeight extends BaseSpecification
{

    public function __construct(private readonly float $minWeight, ?string $context = null)
    {
        parent::__construct($context);
    }

    public static function c(float $minWeight, ?string $context = null): self
    {
        return new self($minWeight, $context);
    }

    protected function getSpec(): Filter|QueryModifier
    {
        return Spec::lte('averageWeight', $this->minWeight);
    }

}
