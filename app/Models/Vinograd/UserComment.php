<?php

namespace App\Models\Vinograd;

use Illuminate\Database\Eloquent\Model;

class UserComment extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'email', 'regdate'];

    public static function add($name, $email)
    {
        return self::firstOrCreate(
                ['name' => $name, 'email' => $email],
                ['regdate' => time()]
            );
    }
}
