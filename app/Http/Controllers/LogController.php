<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LogController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $logs = Log::with([
            'user',
            'operation'
        ])
            ->when($request->input('search_term'), function ($query, $term) {
                $query->whereHas('user',function ($query) use ($term) {
                    $query->where('name', 'like', '%' . $term . '%');
                });

                $query->whereHas('operation',function ($query) use ($term) {
                    $query->where('name', 'like', '%' . $term . '%');
                });
            })
            ->when($request->input('date'),  function ($query, $date) {
                $query->whereBetween('created_at', [
                    Carbon::parse($date)->format('Y-m-d 00:00:00'),
                    Carbon::parse($date)->format('Y-m-d 23:59:59'),
                ]);
            })
            ->paginate($request->input('per_page', 10));

        return response()->json([
            'status' => true,
            'logs' => $logs
        ]);
    }
}
