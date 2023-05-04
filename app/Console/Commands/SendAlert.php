<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Booking;
use Phattarachai\LineNotify\Line;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class SendAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

     //protected $signature = 'command:name'; ($signature ชื่อสำหรับเรียกใช้ command)
     protected $signature = 'command:sendalert';

    /**
     * The console command description.
     *
     * @var string
     */

    // protected $description = 'Command description';
    protected $description = 'Send alert every minute using cron job.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return 0;



            $expiredBookings = Booking::leftJoin('projects', 'projects.id', '=', 'bookings.project_id')
            ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
            ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
            ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
            ->select('bookings.*', 'projects.*', 'bookingdetails.*','bookings.id as bkid','teams.id', 'teams.team_name', 'subteams.subteam_name')
            ->where('bookings.booking_status', '=', '0')
            ->get();



            foreach ($expiredBookings as $booking) {
                $bookingId = $booking->bkid;
                $Strdate_start = date('d/m/Y',strtotime($booking->booking_start));
                $start_time = date('H:i',strtotime($booking->booking_start));
                $end_time = date('H:i',strtotime($booking->booking_end));

                DB::table('bookings')
                    ->where('id', '=', $bookingId)
                    ->where('booking_status', '=', '0')
                    ->update([
                        'bookings.booking_status' => '5',
                        'bookings.because_cancel_remark' => 'ถูกยกเลิกอัตโนมัติ',
                    ]);

                    $token_line = config('line-notify.access_token_project');
                    $line = new Line($token_line);
                    $line->send(" *การจองถูกยกเลิก อัตโนมัติ* \n".
                    "รายการ : *".$booking->booking_title."* \n".
                    "โครงการ : *".$booking->project_name."* \n".
                    "วัน/เวลา : *".$Strdate_start.' '.$start_time."-".$end_time."* \n".
                    "ลูกค้าชื่อ : *".$booking->customer_name."* \n".
                    "------------------- \n".
                    'เจ้าหน้าที่โครงการ : *'.$booking->emp_name."* \n".
                    "*เนื่องจาก ไม่กดรับจองภายในเวลาที่กำหนด");

            }







        $this->info('Daily report has been sent successfully!');
        return 'Daily report has been sent successfully!';
    }
}
