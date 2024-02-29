<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'action', 'description'];

    public static function addLog($user, $action, $description)
    {
        self::create([
            'user_id' => $user,
            'action' => $action,
            'description' => $description
        ]);
    }
}
