<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Dto\SearchParamDto;
use App\Controller\Dto\SortParamDto;
use App\Repository\GameRepository;
use App\Service\ImportData;
use App\Spec as AppSpec;
use Happyr\DoctrineSpecification\Spec;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/', name: 'library')]
class Library extends AbstractController
{

    public function __construct(
        private readonly GameRepository $repository,
        private readonly ImportData $storage,
    ) {
    }

    public function __invoke(SortParamDto $sortParam, SearchParamDto $searchParam): Response
    {
        // andX() should be called "all()"
        $spec = Spec::andX();

        $searchParams = [
            'weight'       => '', // can be "<= weight" or ">= weight"
            'minAge'       => '',
            'hasMechanic'  => '',
            'fromDesigner' => '',
            'inCategory'   => '',

        ];

        if ($searchParam->playerCount > 0 && $searchParam->exactPlayerCount) {
            $spec->andX(AppSpec\MaxPlayerCountEquals::c($searchParam->playerCount));
        } elseif ($searchParam->playerCount > 0 && ! $searchParam->exactPlayerCount) {
            $spec->andX(AppSpec\CanBePlayedWith::c($searchParam->playerCount));
        }


        if ($searchParam->playtime > 0 && $searchParam->minPlaytime) {
            $spec->andX(AppSpec\MinPlaytime::c($searchParam->playtime));
        } elseif ($searchParam->playtime > 0 && ! $searchParam->minPlaytime) {
            $spec->andX(AppSpec\MaxPlaytime::c($searchParam->playtime));
        }

        if ($searchParam->gameName !== '') {
            $spec->andX(AppSpec\GameNameContains::c($searchParam->gameName));
        }

        // sort order
        $spec->andX(Spec::orderBy($sortParam->sortColumn->value, $sortParam->sortDirection->value));

        return $this->render(
            'main.html.twig',
            [
                'games'        => $this->repository->match($spec),
                'import'       => $this->storage->fetchLatestImportData(),
                'sortParams'   => $sortParam,
                'searchParams' => $searchParam,
            ]
        );
    }
}
