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
        $args     = array_merge((array)$searchParam, ['orderBy' => $key, 'order' => $ascending ? null : 'DESC']);
        $filtered = array_filter($args, fn($e) => $e !== null);

        return $this->urlGenerator->generate('library', $filtered);
    }

}
