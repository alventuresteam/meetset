<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $casts = ['emails' => 'array'];
    protected $fillable = [
        'start_date',
        'start_time',
        'end_time',
        'room_id',
        'organizer_name',
        'emails',
        'title',
        'comment',
    ];


    protected static function boot()
    {
        parent::boot();

        self::saved(function($item) {
            $item->room->has_new_reservs = true;
            $item->room->save();
        });

        self::deleting(function($item) {
            $item->room->has_new_reservs = true;
            $item->room->save();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }
}
