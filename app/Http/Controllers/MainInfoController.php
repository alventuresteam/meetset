<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationResource;
use App\Models\Contact;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;

class MainInfoController extends Controller
{
    public function getRoomInfo($room_id)
    {
        $roomInfo = Room::findOrFail($room_id);

        $today = Reservation::query()
            ->where('room_id', $room_id)
            ->where('start_date',today())
            ->where(function($q) {
                $q->where('start_time', '>', now()->format('H:i'))
                    ->orWhere('end_time','>', now()->subMinutes(3)->format('H:i'));
            })
            ->orderBy('start_time')
            ->get()
            ->transform(function($item) {
                $contacts = Contact::query()
                    ->select('email','name','surname')
                    ->whereIn('email', $item->emails)
                    ->get();
                $item->contacts = $contacts;
                return $item;
            });


        $tomorrow = Reservation::query()
            ->where('room_id', $room_id)
            ->where('start_date',now()->addDay())
            ->orderBy('start_time')
            ->get()
            ->transform(function($item) {
                $contacts = Contact::query()
                    ->select('email','name','surname')
                    ->whereIn('email', $item->emails)
                    ->get();
                $item->contacts = $contacts;
                return $item;
            });


        $today = ReservationResource::collection($today);
        $tomorrow = ReservationResource::collection($tomorrow);
        $reservations = compact('today', 'tomorrow');
        return compact('roomInfo', 'reservations');
    }

    public function check($id)
    {
        $room = Room::find($id);
        $status = $room->has_new_reservs;

        $tempData = $room->new_reservs_data ?: [];
        if($status) {
            $tempData['all_other'] = true;
        }else {
            $status = $tempData['all_other'] ?? false;
            $tempData['all_other'] = false;
        }


        $room->new_reservs_data = $tempData;


        $room->has_new_reservs = false;
        $room->save();

        return response()->json(['status' => $status]);
    }
}
