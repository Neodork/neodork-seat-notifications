<?php

namespace Neodork\SeatNotifications\Http\Controllers\Api\v2;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;
use Neodork\SeatNotifications\Entities\NotificationCharacter;
use Neodork\SeatNotifications\Interpreter\CharacterPayloadInterpreter;
use Neodork\SeatNotifications\Interpreter\UpdateNotifcationCharacterGroupInterpreter;
use Seat\Api\Http\Controllers\Api\v2\ApiController;
use Seat\Eveapi\Models\Character\CharacterInfo;

/**
 * Class CharacterController.
 *
 * @package  Seat\Api\v2
 */
class NotificationCharacterController extends ApiController
{

    public function updateNotificationGroup()
    {
        $data = Input::all();

        $interpreter = new UpdateNotifcationCharacterGroupInterpreter($data);

        if (!$interpreter->isValid()) {
            return response()->json([
                'error' => 'Payload is not valid!'
            ], 400);
        }

        NotificationCharacter::where('group', $interpreter->getGroup())->delete();

        /**
         * @var CharacterPayloadInterpreter $character
         */
        try {
            foreach ($interpreter->getCharacters() as $character) {
                CharacterInfo::where('character_id', '=', $character->getCharacterId())->firstOrFail();

                NotificationCharacter::firstOrCreate([
                    'character_id' => $character->getCharacterId(),
                    'group' => $interpreter->getGroup()
                ]);
            }
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'error' => 'Cannot find character with ID: ' . $character->getCharacterId()
            ], 400);
        }

        return response('', 204);
    }
}
