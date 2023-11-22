<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(mixed $validated)
 * @method static findOrFail($id)
 * @method static find(mixed $get)
 */
class Room extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * @var string[] $casts
     */
    protected $casts = [
        'new_reservs_data' => 'array'
    ];

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'name',
        'address',
        'capacity',
        'floor',
        'status_az_1',
        'status_az_2',
        'status_en_1',
        'status_en_2'
    ];

    /**
     * @return HasMany
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }
}
