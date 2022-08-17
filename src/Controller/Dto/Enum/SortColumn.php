<?php

declare(strict_types=1);

namespace App\Controller\Dto\Enum;

enum SortColumn: string
{

    case NAME = 'name';

    case RATING = 'rating';

    case MIN_PLAYERS = 'minPlayers';

    case MAX_PLAYERS = 'maxPlayers';

    case MIN_TIME = 'minPlaytime';

    case MAX_TIME = 'maxPlaytime';

    case YEAR = 'yearPublished';

    case WEIGHT = 'weight';

    case MIN_AGE = 'minAge';

}
