<?php

namespace Neodork\SeatNotifications\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Neodork\SeatNotifications\Entities\NotificationCharacter;
use Seat\Eveapi\Jobs\Character\Notifications;
use Seat\Eveapi\Models\RefreshToken;

class NotificationsCommand extends Command
{
    const CACHE_DURATION = 600;
    const CACHE_KEY = 'neodork.notifications.last_run_';

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

    /**
     * Execute the console command.
     */
    public function handle()
    {
        NotificationCharacter::groupBy('group')->each(function ($notificationCharacter) {
            $group = $notificationCharacter->group;
            $tokenCount = NotificationCharacter::where('group', '=', $group)->count();
            $cooldown = self::CACHE_DURATION / $tokenCount;

            $cacheKey = self::CACHE_KEY . $group;
            $nextRun = (int)Cache::get($cacheKey);

            if ($nextRun > time()) {
                $timeTillNextRun = $nextRun - time();
                $this->info("Group $group waiting for $timeTillNextRun seconds...");
                return;
            }

            Cache::put($cacheKey, time() + $cooldown, 600);

            $currentDate = now()->subSeconds(self::CACHE_DURATION)->format('Y-m-d H:i:s');
            $notificationCharacter = NotificationCharacter::where([
                ['updated_at', '<=', $currentDate],
                ['group', '=', $group]
            ])->first();

            if ($notificationCharacter !== null) {
                $token = RefreshToken::where('character_id', $notificationCharacter->character_id)->first();
                Notifications::dispatch($token)->onQueue('medium');
                $notificationCharacter->touch();
                $this->info("Processed group $group character token.");
            } else {
                $this->info('No token available.');
            }
        });
    }
}
