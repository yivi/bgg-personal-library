<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Dto\SearchParamDto;
use App\Form\SearchFormType;
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

    public function __invoke(Request $request): Response
    {
        // andX() should be called "all()"
        $spec = Spec::andX();

        $searchParams = [
            'hasMechanic'  => '',
            'fromDesigner' => '',
            'inCategory'   => '',

        ];

        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var SearchParamDto $searchParam */
            $searchParam = $form->getData();

            if ($searchParam->gameName) {
                $spec->andX(AppSpec\GameNameContains::c($searchParam->gameName));
            }

            if ($searchParam->exactPlayerCount) {
                $spec->andX(AppSpec\MaxPlayerCountEquals::c($searchParam->exactPlayerCount));
            } elseif ($searchParam->playerCount > 0) {
                $spec->andX(AppSpec\CanBePlayedWith::c($searchParam->playerCount));
            }

            if ($searchParam->minPlaytime) {
                $spec->andX(AppSpec\MinPlaytime::c($searchParam->minPlaytime));
            }

            if ($searchParam->maxPlaytime) {
                $spec->andX(AppSpec\MaxPlaytime::c($searchParam->maxPlaytime));
            }

            if ($searchParam->recommendedAge) {
                $spec->andX(AppSpec\RecommendedAge::c($searchParam->recommendedAge));
            }

            if ($searchParam->minWeight) {
                $spec->andX(AppSpec\MinWeight::c($searchParam->minWeight));
            }

            if ($searchParam->maxWeight) {
                $spec->andX(AppSpec\MaxWeight::c($searchParam->maxWeight));
            }

            // sort order
            $spec->andX(Spec::orderBy($searchParam->orderBy ?? 'name', $searchParam->order ?? 'DESC'));
        }

        return $this->render(
            'main.html.twig',
            [
                'games'        => $this->repository->match($spec),
                'import'       => $this->storage->fetchLatestImportData(),
                'searchParams' => $searchParam ?? new SearchParamDto(),
                'form'         => $form->createView(),
            ]
        );
    }
}
