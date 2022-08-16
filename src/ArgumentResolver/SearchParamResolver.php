<?php declare(strict_types=1);

namespace App\ArgumentResolver;

use App\Controller\Dto\SearchParamDto;
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
        $q = $request->query;

        $playerCount      = 0;
        $playerCountExact = false;
        $playtime         = 0;
        $minPlaytime      = false;

        if (preg_match('|(=)?\s*(\d+)|', (string)$q->get('playerCount'), $m)) {
            $playerCount      = (int)$m[2];
            $playerCountExact = $m[1] === '=';
        }

        if (preg_match('{([<>])?\s*(\d+)}', (string)$q->get('playtime'), $m)) {
            $playtime    = (int)$m[2];
            $minPlaytime = $m[1] === '>';
        }

        yield new SearchParamDto(
            (string)$q->get('gameName'),
            $playerCount,
            $playerCountExact,
            $playtime,
            $minPlaytime,
            0,
            0
        );
    }


}
