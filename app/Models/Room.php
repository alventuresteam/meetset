<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $casts = [
        'new_reservs_data' => 'array'
    ];
    protected $fillable = ['name','address','capacity','floor'];
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
