<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mysql_user';
    protected $table = 'users';

    public function role_ref()
    {
        return $this->hasMany(Role_user::class, 'id', 'user_id')
                    ->on('mysql')
                    ->where('user_id', $this->id);
    }
}
