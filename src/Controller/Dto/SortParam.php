<?php declare(strict_types=1);


namespace App\Controller\Dto;


class SortParam
{

    public function __construct(
        public readonly SortColumn $sortColumn = SortColumn::NAME,
        public readonly SortOrder $sortOrder = SortOrder::ASC
    ) {
    }

}
