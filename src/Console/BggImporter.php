<?php declare(strict_types=1);


namespace App\Console;

use App\Bgg\Service;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('bgg:importer')]
class BggImporter extends Command
{

    public function __construct(private readonly Service $bggService, private readonly EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $gameIds = $this->bggService->getCollection('Portalludico');

        $games = $this->bggService->getGames(...$gameIds);

        dump(count($games));

        foreach ($games as $game) {
            $this->em->persist($game);
        }

        $this->em->getConnection()->executeQuery('TRUNCATE game');
        $this->em->flush();

        return Command::SUCCESS;
    }


}
