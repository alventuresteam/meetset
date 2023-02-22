<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;

class MainInfoController extends Controller
{
    public function getRoomInfo($room_id)
    {
        $roomInfo = Room::findOrFail($room_id);
        $current = Reservation::query()
                    ->where('room_id', $room_id)
                    ->where('start_date', today())
                    ->whereTime('start_time','<', now())
                    ->whereTime('end_time','>', now())
                    ->first();
        $today = Reservation::query()
            ->where('room_id', $room_id)
            ->where('start_date',today())
            ->where('start_time', '>',now()->format('H:i'))
            ->get();
        $tomorrow = Reservation::query()
            ->where('room_id', $room_id)
            ->where('start_date',now()->addDay())
            ->get();

        if($current) {
            $current = ReservationResource::make($current);
        }

        $today = ReservationResource::collection($today);
        $tomorrow = ReservationResource::collection($tomorrow);
        $isRoomFree = !$current;
        $reservations = compact('current','today', 'tomorrow');
        return compact('roomInfo','isRoomFree', 'reservations');
    }
}
