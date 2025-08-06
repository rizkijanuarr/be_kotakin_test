<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\Todo;
use App\Helpers\Status as StatusHelper;
use Illuminate\Support\Facades\DB;

class DashboardControllerV1 extends Controller
{
    public function dashboard()
    {
        $counts = [];
        foreach (StatusHelper::all() as $slug) {
            $counts[$slug] = Status::where('slug', $slug)->count();
        }

        $year = date('Y');

        $transactions = DB::table('todos as t')
            ->join('statuses as s', 't.status_id', '=', 's.id')
            ->where('s.slug', StatusHelper::COMPLETED)
            ->whereYear('t.created_at', $year)
            ->selectRaw('COUNT(t.id) as total')
            ->selectRaw('MONTH(t.created_at) as month')
            ->selectRaw('MONTHNAME(t.created_at) as month_name')
            ->groupByRaw('month, month_name')
            ->orderBy('month')
            ->get();
        if (count($transactions)) {
            foreach ($transactions as $result) {
                $month_name[] = $result->month_name;
                $grand_total[] = (int) $result->total;
            }
        } else {
            $month_name[] = '';
            $grand_total[] = '';
        }

        
        return response()->json([
            'success' => true,
            'message' => 'Statistik Data',
            'data' => [
                'count' => $counts,
                'chart' => [
                    'month_name' => $month_name,
                    'grand_total' => $grand_total
                ]
            ]
        ], 200);
    }
}
