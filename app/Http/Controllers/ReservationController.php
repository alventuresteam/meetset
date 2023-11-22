<?php

namespace App\Http\Controllers;

use App\Classes\ICS;
use App\Events\NewReservationEvent;
use App\Http\Requests\ReservRequest;
use App\Mail\SendReservation;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        return Reservation::query()
            ->orderBy('start_time')
            ->limit(30)
            ->get();
    }

    public function create(ReservRequest $request)
    {
        return $request->all();

        $start_time = Carbon::parse($request->get('start_time'));
        $end_time   = Carbon::parse($request->get('end_time'));
        $start_date = Carbon::parse($request->get('start_date'));

        if($start_time < now() && $start_date <= now()) {
            return response()
                ->json(['success' => false, 'message' => 'Keçmiş zamanda rezervasiya yaratmaq mümkün deyil.'],422);
        }

        $current = Reservation::query()
            ->where('room_id', $request->get('room_id'))
            ->where('start_date', $start_date)
            ->where(function($q) use($start_time, $end_time) {
                $q->where(function($q) use ($start_time) {
                    $q->where('start_time','<', $start_time)
                      ->where('end_time','>', $start_time);
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

            $db_start_time = Carbon::parse($item->start_time);
            $db_end_time = Carbon::parse($item->end_time);
            if($db_start_time < $start_time && $db_end_time > $end_time) {
                return response()
                    ->json(['success' => false, 'message' => 'Bu aralıqda artıq rezervasiya var.'],422);
            }
        }

        $reservation = $request->user('sanctum')
            ->reservations()
            ->create($request->validated());

        NewReservationEvent::dispatch($reservation);

        $ics = new ICS();

        $date = Carbon::parse($request->get('start_date'))->format('Y-m-d');

        $start = $date.' '.$start_time->format('H:i');
        $end = $date. ' '. $end_time->format('H:i');


        $ics->setOrganizer($reservation->organizer_name,'elchin.m@al.ventures');
        $ics->setParticipiants($reservation->to_emails);

        $ics->ICS(
            $start,
            $end,
            $reservation->title,
            $reservation->comment,
            'Baku'
        );
        Mail::to($reservation->emails)->send(new SendReservation($ics));

        return response()->json(['success' => true]);
    }

    public function update(ReservRequest $request, $id)
    {
        $start_time = Carbon::parse($request->get('start_time'));
        $end_time = Carbon::parse($request->get('end_time'));
        $start_date = Carbon::parse($request->get('start_date'));

        $current = Reservation::query()

            ->where('room_id', $request->get('room_id'))
            ->where('start_date', $start_date)
            ->where('id','<>',$id)
            ->where(function($q) use($start_time, $end_time) {
                $q->where(function($q) use ($start_time) {
                    $q->where('start_time','<=', $start_time)
                        ->where('end_time','=>', $start_time);
                });
                $q->orWhereBetween('start_time', [ $start_time, $end_time ]);
                $q->orWhereBetween('end_time', [ $start_time, $end_time ]);

            })
            ->first();


        if($start_time < now() && $start_date <= now()) {
            return response()
                ->json(['success' => false, 'message' => 'Keçmiş zamanda rezervasiya yaratmaq mümkün deyil.'],422);
        }

        if($current)
            return response()
                ->json(['success' => false, 'message' => 'Bu aralıqda artıq rezervasiya var.'],422);

        $current = Reservation::query()
            ->where('room_id', $request->get('room_id'))
            ->where('start_date', Carbon::parse($request->get('start_date')))
            ->where('id','<>',$id)
            ->get();

        foreach($current as $item) {

            $db_start_time = Carbon::parse($item->start_time);
            $db_end_time = Carbon::parse($item->end_time);
            if($db_start_time < $start_time && $db_end_time > $end_time) {
                return response()
                    ->json(['success' => false, 'message' => 'Bu aralıqda artıq rezervasiya var.'],422);
            }
        }
        $reservation = Reservation::findOrFail($id);

        if($reservation->user_id != auth('sanctum')->id())
            return response()
                ->json(['success' => false, 'message' => 'Bu reservasiya sizə aid deyil.'],422);

        $reservation->update($request->validated());

        return response()->json(['success' => true]);
    }
    public function delete($id)
    {
        $reservation = Reservation::findOrFail($id);
            NewReservationEvent::dispatch($reservation);
        $reservation->delete();
        return response()->json(['success' => true]);
    }
}
