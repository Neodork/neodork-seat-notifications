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

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Neodork\SeatNotifications\Entities\NotificationCharacter;
use Seat\Eveapi\Jobs\Character\Notifications;
use Seat\Eveapi\Models\RefreshToken;

class NotificationsCommand extends Command
{
    const CACHE_DURATION = 600;
    const CACHE_KEY = 'neodork.notifications.last_run';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'esi:update:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule updater jobs for notifications';

    private $tokensChecked;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tokenCount = NotificationCharacter::all()->count();
        $cooldown = self::CACHE_DURATION / $tokenCount;

        $nextRun = (int) Cache::get(self::CACHE_KEY);

        if ($nextRun > time()) {
            $timeTillNextRun = $nextRun - time();
            $this->info("Waiting for $timeTillNextRun seconds...");
            return;
        }

        Cache::put(self::CACHE_KEY, time() + $cooldown, 60);

        $currentDate = now()->subSeconds(self::CACHE_DURATION)->format('Y-m-d H:i:s');
        $notificationCharacter = NotificationCharacter::where('updated_at', '<=', $currentDate)->first();
        $token = RefreshToken::where('character_id', $notificationCharacter->character_id)->first();
        Notifications::dispatch($token)->onQueue('medium');
        $notificationCharacter->touch();

        $this->info('Processed notification character token.');
    }
}
