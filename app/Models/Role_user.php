<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Role_user extends Model
{


    public function ref_user()
    {
        $users = Role_user::get();
        return DB::connection('mysql_user')->table('users')->where('id', $users->user_id)->first();

    }
}
