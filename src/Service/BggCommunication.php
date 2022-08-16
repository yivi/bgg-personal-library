<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Game;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BggCommunication
{

    public function __construct(private readonly HttpClientInterface $client)
    {
    }

    /**
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
            $gameType      = (string)$item->attributes()['type'];
            $gameName      = (string)$item->name->attributes()['value'];
            $yearPublished = (int)$item->yearpublished->attributes()['value'];
            $minPlayers    = (int)$item->minplayers->attributes()['value'];
            $maxPlayers    = (int)$item->maxplayers->attributes()['value'];
            $minPlaytime   = (int)$item->minplaytime->attributes()['value'];
            $maxPlaytime   = (int)$item->maxplaytime->attributes()['value'];
            $minAge        = (int)$item->minage->attributes()['value'];

            $categories  = [];
            $mechanics   = [];
            $designers   = [];
            $publisher   = '';
            $expansionTo = [];

            foreach ($item->link as $link) {
                $linkType = (string)$link->attributes()['type'];
                $value    = (string)$link->attributes()['value'];
                switch ($linkType) {
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
                        break;
                    case 'boardgameexpansion':
                        if ($gameType !== 'boardgameexpansion' || 'true' !== (string)$link->attributes()['inbound']) {
                            break;
                        }
                        $expansionTo[] = (int)$link->attributes()['id'];
                }
            }

            $rating     = (float)$item->statistics->ratings->average->attributes()['value'];
            $usersRated = (int)$item->statistics->ratings->usersrated->attributes()['value'];
            $weight     = (float)$item->statistics->ratings->averageweight->attributes()['value'];

            $g[$id] = new Game(
                             $id,
                             $gameType,
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
                             $weight,
                expansionTo: $expansionTo
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

        return array_unique($g);
    }

}
