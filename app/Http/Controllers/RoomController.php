<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

    /**
     * @param RoomRequest $request
     * @return JsonResponse
     */
    public function create(RoomRequest $request): JsonResponse
    {
        $room = Room::create($request->validated());

        if ($request->has('image')) {
            $image = $request->file('image');
            $room->addMedia($image)
                ->usingFileName(Str::uuid() . '.' . $image->extension())
                ->toMediaCollection('image');
        }

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
