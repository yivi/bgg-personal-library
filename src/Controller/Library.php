<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Dto\SortParam;
use App\Repository\GameRepository;
use App\Service\ImportData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/', name: 'library')]
class Library extends AbstractController
{

    public function __construct(private readonly GameRepository $repository, private readonly ImportData $storage)
    {
    }

    public function __invoke(SortParam $sortParam): Response
    {
        return $this->render(
            'main.html.twig',
            [
                'games' => $this->repository->findAll(),
                'import' => $this->storage->fetchLatestImportData(),
                'sort' => $sortParam,
            ]
        );
    }
}
