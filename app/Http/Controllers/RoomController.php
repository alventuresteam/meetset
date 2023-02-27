<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index']]);
    }
    public function index()
    {
        return Room::query()
            ->with(['reservations' => fn($q) => $q->orderBy('start_time')])
            ->get();
    }

    public function create(RoomRequest $request)
    {
        Room::create($request->validated());
        return response()->json(['success' => true]);
    }

    public function view($id)
    {
        return Room::findOrFail($id);
    }

    public function update(RoomRequest $request, $id)
    {
        $room = Room::findOrFail($id);
        $room->update($request->validated());

        return response()->json(['success' => true]);
    }
    public function delete($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return response()->json(['success' => true]);
    }
}
