<?php declare(strict_types=1);

namespace App\ArgumentResolver;

use App\Controller\Dto\SearchParamDto;
use GW\Safe\SafeRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class SearchParamResolver implements ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === SearchParamDto::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $safeRequest = SafeRequest::mustBeFrom($request);
        $q           = $safeRequest->query();

        yield new SearchParamDto(
            $q->stringOrNull('ga'),
            $q->intOrNull('playerCount'),
            $q->intOrNull('exactPlayerCount'),
            $q->intOrNull('minPlaytime'),
            $q->intOrNull('maxPlaytime'),
            $q->floatOrNull('minWeight'),
            $q->floatOrNull('maxWeight'),
            $q->intOrNull('recommendedAge')
        );
    }


}
