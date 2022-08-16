<?php

declare(strict_types=1);

namespace App\Service;

use App\Controller\Dto\SearchParamDto;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PathGenerator
{

    public function __construct(private readonly UrlGeneratorInterface $urlGenerator)
    {
    }

    public function handle(string $key, bool $ascending, SearchParamDto $searchParam): string
    {
        $args = [
            'orderBy' => $key,
        ];

        if ( ! $ascending) {
            $args['order'] = 'DESC';
        }

        if ($searchParam->gameName !== '') {
            $args['gameName'] = $searchParam->gameName;
        }

        if ($searchParam->playtime) {
            $args['playtime'] = ($searchParam->minPlaytime ? '>' : '') . $searchParam->playtime;
        }

        if ($searchParam->playerCount) {
            $args['playerCount'] = ($searchParam->exactPlayerCount ? '=' : '') . $searchParam->playerCount;
        }

        return $this->urlGenerator->generate('library', $args);
    }

}
