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

    public function booking_user_ref()
    {
        return $this->hasMany(User::class,'id','user_id');
    }
    public function booking_emp_ref()//เจ้าหน้าที่โครงการ
    {
        return $this->hasMany(User::class,'id','teampro_id');
    }
    public function booking_project_ref()//ชื่อโครงการ
    {
        return $this->hasMany(Project::class,'id','project_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $y = date('Y')+543;
            $last_two_digits = substr($y, -2);
            $booking->id = $last_two_digits. sprintf('%03d', static::count() + 1);
        });
    }
}
