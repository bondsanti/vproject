<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'old', 'new'];

    public static function addLog($user, $old, $new)
    {
        self::create([
            'user_id' => $user,
            'old' => $old,
            'new' => $new
        ]);
    }
}
