<?php

declare(strict_types=1);

namespace App\Controller\Dto;

class SortParamDto
{

    const DEFAULT_COLUMN = Enum\SortColumn::NAME;

    const DEFAULT_ORDER  = Enum\SortDirection::ASC;

    public function __construct(
        public readonly Enum\SortColumn $sortColumn = self::DEFAULT_COLUMN,
        public readonly Enum\SortDirection $sortDirection = self::DEFAULT_ORDER
    ) {
    }

}
