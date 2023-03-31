<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $connection = 'mysql_user';
    protected $table = 'users';

    public function role_ref()
    {

        return $this->belongsTo(Role_user::class,'id','user_id');
    }

    public function user_ref_booking()
    {

        return $this->belongsTo(Role_user::class,'id','user_id');
    }
}
