<?php

declare(strict_types=1);

namespace App\Spec;

use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;
use Happyr\DoctrineSpecification\Spec;
use Happyr\DoctrineSpecification\Specification\BaseSpecification;

use function mb_strtolower;

class GameNameContains extends BaseSpecification
{

    public function __construct(private readonly string $partialName, ?string $context = null)
    {
        parent::__construct($context);
    }

    public static function c(string $partialName, ?string $context = null): self
    {
        return new self($partialName, $context);
    }

    protected function getSpec(): Filter|QueryModifier
    {
        return Spec::like(Spec::LOWER('name'), mb_strtolower($this->partialName));
    }

}
