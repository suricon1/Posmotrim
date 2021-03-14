<?php

namespace App\Models\Vinograd;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contact extends Model
{
    use Notifiable;

    protected $table = 'vinograd_contact';
    public $timestamps = false;
    protected $fillable = ['name', 'email', 'message', 'date_at', 'parent_id', 'mark_as_read'];

    public function parent()
    {
        return $this->belongsTo(Contact::class, 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }

    public function is_reply()
    {
        return $this->parent ? true : false;
    }

    public function routeNotificationForMail($notification)
    {
        return config('main.admin_email');
    }
}
