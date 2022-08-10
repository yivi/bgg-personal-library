<?php

declare(strict_types=1);


namespace App\Repository;


use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class GameRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function truncate(): void
    {
        $this->getEntityManager()
             ->getConnection()
             ->executeQuery("TRUNCATE games");
    }

}
