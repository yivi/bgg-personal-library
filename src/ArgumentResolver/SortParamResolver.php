<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use App\Controller\Dto\Enum\SortColumn;
use App\Controller\Dto\Enum\SortDirection;
use App\Controller\Dto\SortParamDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class SortParamResolver implements ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === SortParamDto::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $q = $request->query;
        yield new SortParamDto(
            SortColumn::tryFrom((string)$q->get('orderBy')) ?? SortColumn::NAME,
            SortDirection::tryFrom((string)$q->get('order')) ?? SortDirection::DESC
        );
    }

}
