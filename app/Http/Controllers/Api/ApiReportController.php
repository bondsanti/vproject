<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiReportController extends Controller
{
    //รายงานการนัดเยี่ยมแต่ละเดือน
    public function ReportBookingAllCurrentYear()
    {
        $currentYear = Carbon::now()->year;

        $bookings = Booking::with('booking_project_ref:id,name')
            ->select(DB::raw('COUNT(id) as total_bookings'),
            DB::raw('MONTH(booking_start) as month'), 'project_id',
            DB::raw('SUM(booking_status = 3) as success'),
            DB::raw('SUM(booking_status = 4) as reject'),
            DB::raw('SUM(booking_status = 5) as reject_bysystem'))
            ->whereYear('booking_start', $currentYear)
            ->whereIn('booking_status',[3,4,5])
            ->groupBy('month', 'project_id','booking_status')
            ->orderBy('month')
            ->get();


        $jsonData = [];

        foreach ($bookings as $booking) {
            $projectName = null;

            if ($booking->booking_project_ref) {
                $projectName = $booking->booking_project_ref[0]->name;
            }

            $jsonData[] = [
                'project_name' => $projectName,
                'month' => $booking->month,
                'total_bookings' => $booking->total_bookings,
                'success' => $booking->success,
                'reject' => $booking->reject,
                'reject_bysystem' => $booking->reject_bysystem,

            ];
        }

        return response()->json($jsonData, 200);

    }


}
