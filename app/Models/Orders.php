<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'delivery_address',
        'order_total',
        'order_status',
        'delivery_id',
    ];

    public function deliveries()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }
}
