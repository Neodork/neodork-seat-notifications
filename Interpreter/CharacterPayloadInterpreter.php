<?php

namespace Neodork\SeatNotifications\Interpreter;


class CharacterPayloadInterpreter
{

    const CHARACTER_INDEX = 'characterId';

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getCharacterId(){
        return $this->data['characterId'];
    }

}
