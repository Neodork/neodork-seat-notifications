<?php

namespace Neodork\SeatNotifications\Entities;

use Illuminate\Database\Eloquent\Model;

class NotificationCharacter extends Model
{
    protected $fillable = ['character_id', 'last_queried'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'neodork_seat_notifications';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'character_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

}
