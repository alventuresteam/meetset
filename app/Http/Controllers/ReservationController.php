<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservRequest;
use App\Models\Reservation;
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
        $request->user('sanctum')
            ->reservations()
            ->create($request->validated());

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
