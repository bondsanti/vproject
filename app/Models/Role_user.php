<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Role_user extends Model
{

    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'role_users';

    //public $timestamps = false;

    public function user_ref()
    {
        return $this->hasMany(User::class,'id','user_id');
    }

}
