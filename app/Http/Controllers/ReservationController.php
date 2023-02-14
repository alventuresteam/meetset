<?php

namespace App\Http\Controllers;

use App\Events\NewReservationEvent;
use App\Http\Requests\ReservRequest;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        return Reservation::query()->get();
    }

    public function create(ReservRequest $request)
    {
        $start_time = Carbon::parse($request->get('start_time'));
        $end_time = Carbon::parse($request->get('end_time'));
        $current = Reservation::query()
            ->where('room_id', $request->get('room_id'))
            ->where('start_date', Carbon::parse($request->get('start_date')))
            ->where(function($q) use($start_time, $end_time) {
                $q->where(function($q) use ($start_time) {
                    $q->where('start_time','<=', $start_time)
                      ->where('end_time','=>', $start_time);
                });
                $q->orWhereBetween('start_time', [ $start_time, $end_time ]);
                $q->orWhereBetween('end_time', [ $start_time, $end_time ]);

            })
            ->first();




        if($current)
            return response()
                ->json(['success' => false, 'message' => 'Bu aralıqda artıq rezervasiya var.'],422);

        $current = Reservation::query()
            ->where('room_id', $request->get('room_id'))
            ->where('start_date', Carbon::parse($request->get('start_date')))
            ->get();

        foreach($current as $item) {
            if($item->start_time < $start_time && $item->end_time < $end_time && $start_time > $item->end_time) {
                return response()
                    ->json(['success' => false, 'message' => 'Bu aralıqda artıq rezervasiya var.'],422);
            }
        }
        //04:01 - 04:59
        // 04:00 - 06:00


        $reservation = $request->user('sanctum')
            ->reservations()
            ->create($request->validated());

        NewReservationEvent::dispatch($reservation);

        //TODO event send mails
        return response()->json(['success' => true]);
    }

    public function update(ReservRequest $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update($request->validated());

        return response()->json(['success' => true]);
    }
    public function delete($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response()->json(['success' => true]);
    }
}
