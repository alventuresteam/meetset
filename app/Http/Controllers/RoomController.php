<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    /**
     * RoomController constructor
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index']]);
    }

    /**
     * @return Collection|array
     */
    public function index(): Collection|array
    {
        $rooms =  Room::query()
            ->with(['reservations' => fn($q) => $q->orderBy('start_time')])
            ->get();

        foreach ($rooms as $room) {
            $room->image = $room->getFirstMediaUrl('image');
        }

        return $rooms;
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

    /**
     * @param $id
     * @return mixed
     */
    public function view($id): mixed
    {
        return Room::findOrFail($id);
    }

    /**
     * @param RoomRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(RoomRequest $request, $id): JsonResponse
    {
        $room = Room::findOrFail($id);

        $room->update($request->validated());

        if ($request->has('image')) {
            $image = $request->file('image');
            $room->addMedia($image)
                ->usingFileName(Str::uuid() . '.' . $image->extension())
                ->toMediaCollection('image');
        }

        return response()->json(['success' => true]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $room = Room::findOrFail($id);

        $room->delete();

        return response()->json(['success' => true]);
    }
}
