<?php declare(strict_types=1);

namespace App\Bgg;


use App\Entity\Game;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Service
{

    public function __construct(private readonly HttpClientInterface $client)
    {
    }

    /**
     *
     * @return array<Game>
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getGames(int...$gameIds): array
    {
        $response = $this->client->request(Request::METHOD_GET, 'https://boardgamegeek.com/xmlapi2/thing?stats=1&id=' . implode(',', $gameIds));
        $g        = [];

        $xml   = $response->getContent();
        $items = simplexml_load_string($xml);

        foreach ($items->children() as $item) {
            $id            = (int)$item->attributes()['id'];
            $gameName      = (string)$item->name->attributes()['value'];
            $yearPublished = (int)$item->yearpublished->attributes()['value'];
            $minPlayers    = (int)$item->minplayers->attributes()['value'];
            $maxPlayers    = (int)$item->minplaytime->attributes()['value'];
            $minPlaytime   = (int)$item->minplaytime->attributes()['value'];
            $maxPlaytime   = (int)$item->maxplaytime->attributes()['value'];
            $minAge        = (int)$item->minage->attributes()['value'];

            $categories = [];
            $mechanics  = [];
            $designers  = [];
            $publisher  = '';

            foreach ($item->link as $link) {
                $type  = (string)$link->attributes()['type'];
                $value = (string)$link->attributes()['value'];
                switch ($type) {
                    case 'boardgamemechanic':
                        $mechanics[] = $value;
                        break;
                    case 'boardgamecategory':
                        $categories[] = $value;
                        break;
                    case 'boardgamedesigner':
                        $designers[] = $value;
                        break;
                    case 'boardgamepublisher':
                        if ($publisher !== '') {
                            continue 2;
                        }
                        $publisher = $value;
                }
            }

            $rating     = (float)$item->statistics->ratings->average->attributes()['value'];
            $usersRated = (int)$item->statistics->ratings->usersrated->attributes()['value'];
            $weight     = (float)$item->statistics->ratings->averageweight->attributes()['value'];

            $g[] = new Game(
                $id,
                $gameName,
                $yearPublished,
                $minPlayers,
                $maxPlayers,
                $minPlaytime,
                $maxPlaytime,
                $minAge,
                $categories,
                $mechanics,
                $designers,
                $publisher,
                $rating,
                $usersRated,
                $weight
            );
        }

        return $g;
    }

    /**
     * @return array<int>
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getCollection(string $username): array
    {
        $response = $this->client->request(Request::METHOD_GET, 'https://boardgamegeek.com/xmlapi2/collection?username=' . $username);
        $g        = [];

        $xml   = $response->getContent();
        $items = simplexml_load_string($xml);

        foreach ($items->children() as $game) {
            $g[] = (int)$game->attributes()['objectid'];
        }

        dump(count($g));
        $g = array_unique($g);
        dump(count($g));

        return $g;
    }

}
