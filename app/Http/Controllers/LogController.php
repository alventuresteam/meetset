<?php

namespace App\Http\Controllers;

use App\Http\Resources\LogResource;
use Carbon\Carbon;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Shuchkin\SimpleXLSXGen;

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
                })->orWhereHas('operation',function ($query) use ($term) {
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

    /**
     * @param Request $request
     * @return void
     */
    public function exportData(Request $request): void
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
            })->get();


        $excelData[] = ['ID', 'FULLNAME', 'DATE', 'OPERATION'];

        foreach ($logs as $log) {
            $excelData[] = [
                $log->id,
                $log->user?->name ?? '-',
                Carbon::parse($log->created_at)->format('Y-m-d H:i:s'),
                $log->operation->name
            ];
        }

        SimpleXLSXGen::fromArray($excelData)
            ->setDefaultFont('Arial')
            ->setDefaultFontSize(14)
            ->download();
    }

}
