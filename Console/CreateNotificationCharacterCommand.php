<?php

/*
 * This file is part of SeAT
 *
 * Copyright (C) 2015, 2016, 2017, 2018, 2019  Leon Jacobs
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

namespace Neodork\SeatNotifications\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Neodork\SeatNotifications\Entities\NotificationCharacter;
use Seat\Console\Bus\CharacterTokenShouldUpdate;
use Seat\Eveapi\Jobs\Character\Notifications;
use Seat\Eveapi\Models\Character\CharacterNotification;
use Seat\Eveapi\Models\RefreshToken;

class CreateNotificationCharacterCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'neodork:nc {character_id} {mode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create notification user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $characterId = $this->argument('character_id');
        $mode = $this->argument('mode');

        if($mode === 'delete'){
            NotificationCharacter::where(['character_id' => $characterId])->delete();
        }else if($mode === 'create'){
            NotificationCharacter::firstOrCreate(['character_id' => $characterId]);
        }

        $this->info('Processed notification character tokens.');
    }
}
