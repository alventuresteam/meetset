<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    /**
     * @var string[] $casts
     */
    protected $casts = ['emails' => 'array'];

    /**
     * @var string[] $fillable
     */
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

    /**
     * @return void
     */
    protected static function boot(): void
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

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
