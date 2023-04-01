<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $connection = 'mysql';
    protected $table = 'holiday_users';
    use HasFactory;

    public $timestamps = false;

    public function user_ref()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

}
