<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Seat\Eveapi\Models\Character\CharacterNotification;

class UpdateNotificationCharacterForGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('neodork_seat_notifications', function (Blueprint $table) {
           $table->string('group');
        });

        // Truncate old data to allow external component to manage the entries.
        DB::table('neodork_seat_notifications')->truncate();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('neodork_seat_notifications', function (Blueprint $table) {
            $table->dropColumn('group');
        });
    }
}
