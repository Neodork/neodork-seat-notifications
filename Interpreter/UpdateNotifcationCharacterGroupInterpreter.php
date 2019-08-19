<?php

namespace Neodork\SeatNotifications\Interpreter;


class UpdateNotifcationCharacterGroupInterpreter
{

    const GROUP_INDEX = 'group';
    const CHARACTER_INDEX = 'characters';

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getGroup(){
        return $this->data[self::GROUP_INDEX];
    }

    public function isValid(){
        if(array_key_exists(self::GROUP_INDEX, $this->data) === false){
            return false;
        }

        if(array_key_exists(self::CHARACTER_INDEX, $this->data) === false){
            return false;
        }

        return true;
    }

    public function getCharacters(){
        $characters = [];

        foreach ($this->data['characters'] as $character){
            $characters[] = new CharacterPayloadInterpreter($character);
        }

        return $characters;
    }


}
