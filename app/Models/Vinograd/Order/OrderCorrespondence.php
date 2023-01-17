<?php

namespace App\Models\Vinograd\Order;

use Illuminate\Database\Eloquent\Model;

class OrderCorrespondence extends Model
{
    protected $table = 'vinograd_order_correspondence';
    public $timestamps = false;
    protected $fillable = ['order_id', 'created_at', 'message'];
}
