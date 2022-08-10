<?php declare(strict_types=1);


namespace App\Console;

use App\Bgg\Service;
use App\Entity\GameCategory;
use App\Entity\GameDesigner;
use App\Entity\GameMechanic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('bgg:importer')]
class BggImporter extends Command
{

    public function __construct(private readonly Service $bggService, private readonly EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('username', InputArgument::REQUIRED, 'BGG Username');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->em->getConnection()->executeQuery('TRUNCATE games');
        $this->em->getConnection()->executeQuery('TRUNCATE game_mechanics');
        $this->em->getConnection()->executeQuery('TRUNCATE game_designers');
        $this->em->getConnection()->executeQuery('TRUNCATE game_categories');

        $gameIds = $this->bggService->getCollection($input->getArgument('username'));
        $games   = $this->bggService->getGames(...$gameIds);

        $designers  = [];
        $mechanics  = [];
        $categories = [];

        foreach ($games as $game) {
            if ($game->type === 'boardgameexpansion') {
                if (isset($games[$game->expansionTo])) {
                    $games[$game->expansionTo]->expansions[] = $game->name;
                }
                unset($games[$game->bggId]);
            }
            $this->em->persist($game);

            $designers  = array_merge($designers, $game->designers);
            $mechanics  = array_merge($mechanics, $game->mechanics);
            $categories = array_merge($categories, $game->categories);
        }

        foreach (array_unique($designers) as $designer) {
            $gameDesigner = new GameDesigner($designer);
            $this->em->persist($gameDesigner);
        }
        foreach (array_unique($categories) as $category) {
            $gameCategory = new GameCategory($category);
            $this->em->persist($gameCategory);
        }

        foreach (array_unique($mechanics) as $mechanic) {
            $gameMechanic = new GameMechanic($mechanic);
            $this->em->persist($gameMechanic);
        }

        $this->em->flush();

        return Command::SUCCESS;
    }


}
