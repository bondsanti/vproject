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

    // public function project_ref()
    // {
    //     return $this->belongsTo(Project::class,'id','project_id');
    // }
}
