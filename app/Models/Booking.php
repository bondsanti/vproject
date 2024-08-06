<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'id','booking_title','booking_start','booking_end','booking_title','booking_status','project_id','booking_status_df','teampro_id','team_id'
    //     ,'subteam_id','user_id','user_tel','remark'
    // ];
    protected $table = 'bookings';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $guarded = [];


    public function booking_user_ref()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
    public function booking_emp_ref() //เจ้าหน้าที่โครงการ
    {
        return $this->hasMany(User::class, 'id', 'teampro_id');
    }
    public function booking_project_ref() //ชื่อโครงการ
    {
        return $this->hasMany(Project::class, 'id', 'project_id');
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($booking) {
    //         $y = date('Y') + 543;
    //         $last_two_digits = substr($y, -2);

    //         // ดึง ID ล่าสุดที่ขึ้นต้นด้วยปีปัจจุบัน
    //         $lastBooking = static::where('id', 'like', $last_two_digits . '%')
    //             ->orderBy('id', 'desc')
    //             ->first();

    //         if ($lastBooking) {
    //             // แยกเลขท้ายของ ID ล่าสุดออกมา
    //             $lastId = substr($lastBooking->id, 2);
    //             $nextId = sprintf('%03d', $lastId + 1);
    //         } else {
    //             $nextId = '001';
    //         }

    //         // สร้าง ID ใหม่
    //         $booking->id = $last_two_digits . $nextId;
    //     });
    // }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $currentYear = date('Y') + 543;
            $last_two_digits = substr($currentYear, -2);

            // ดึง ID ล่าสุดที่ขึ้นต้นด้วยปีปัจจุบัน
            $lastBooking = static::orderBy('id', 'desc')->first();

            if ($lastBooking) {
                $lastYearDigits = substr($lastBooking->id, 0, 2);
                if ($lastYearDigits === $last_two_digits) {
                    // ถ้าปีเดียวกัน แยกเลขท้ายของ ID ล่าสุดออกมา
                    $lastId = substr($lastBooking->id, 2);
                    $nextId = sprintf('%03d', $lastId + 1);
                } else {
                    // ถ้าปีเปลี่ยน เริ่มใหม่จาก 001
                    $nextId = '001';
                }
            } else {
                $nextId = '001';
            }

            // สร้าง ID ใหม่
            $booking->id = $last_two_digits . $nextId;
        });
    }
}
