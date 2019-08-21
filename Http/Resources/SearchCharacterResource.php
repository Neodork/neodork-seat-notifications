<?php

namespace Neodork\SeatNotifications\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SearchCharacterResource extends Resource
{

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $definition = parent::toArray($request);

        array_forget($definition, 'description');
        array_forget($definition, 'alliance_id');
        array_forget($definition, 'corporation_id');
        array_forget($definition, 'birthday');
        array_forget($definition, 'gender');
        array_forget($definition, 'race_id');
        array_forget($definition, 'bloodline_id');
        array_forget($definition, 'ancestry_id');
        array_forget($definition, 'security_status');
        array_forget($definition, 'faction_id');
        array_forget($definition, 'created_at');
        array_forget($definition, 'updated_at');

        return $definition;
    }
}
