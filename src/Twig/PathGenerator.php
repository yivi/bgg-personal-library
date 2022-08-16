<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PathGenerator extends AbstractExtension
{

    public function __construct(private readonly \App\Service\PathGenerator $pathGenerator)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('libraryPath', [$this->pathGenerator, 'handle']),
        ];
    }
}
