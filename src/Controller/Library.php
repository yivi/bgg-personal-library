<?php

declare(strict_types=1);

namespace App\Controller;

use App\Bgg\Service;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/', name: 'root')]
class Library extends AbstractController
{

    public function __construct(private readonly GameRepository $repository)
    {
    }

    public function __invoke(Request $request): Response
    {
        return $this->render('main.html.twig', ['games' => $this->repository->findAll()]);
    }

}
