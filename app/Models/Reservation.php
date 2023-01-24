<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
