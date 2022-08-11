<?php declare(strict_types=1);


namespace App\ArgumentResolver;


use App\Controller\Dto\SortColumn;
use App\Controller\Dto\SortOrder;
use App\Controller\Dto\SortParam;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class SortParamResolver implements ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === SortParam::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $sort   = SortColumn::tryFrom((string)$request->query->get('orderBy')) ?? SortColumn::NAME;
        $sortBy = SortOrder::tryFrom((string)$request->query->get('order')) ?? SortOrder::DESC;

        yield new SortParam($sort, $sortBy);
    }


}
