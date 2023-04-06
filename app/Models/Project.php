<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $connection = 'mysql_project';
    protected $table = 'projects';

    public function project_ref()
    {
        return $this->belongsTo(Booking::class,'id','project_id');
    }
}
