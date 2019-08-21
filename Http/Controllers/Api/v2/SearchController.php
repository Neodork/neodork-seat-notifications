<?php

namespace Neodork\SeatNotifications\Http\Controllers\Api\v2;

use Neodork\SeatNotifications\Http\Resources\SearchCharacterResource;
use Seat\Api\Http\Controllers\Api\v2\ApiController;
use Seat\Eveapi\Models\Character\CharacterInfo;

/**
 * Class CharacterController.
 *
 * @package  Seat\Api\v2
 */
class SearchController extends ApiController
{

    public function searchCharacter($name)
    {
        return SearchCharacterResource::collection(CharacterInfo::where('name', 'LIKE', '%' . $name . '%')->get());
    }
}
