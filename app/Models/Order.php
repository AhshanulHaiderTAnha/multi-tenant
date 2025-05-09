<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // 'tenant_id', // multi tenancy
        'user_id',
        // 'shipment_id',
        'order_email',
        'order_name',
        // 'order_address',
        // 'order_bus',
        // 'order_postcode',
        // 'order_city',
        'order_status',
        'order_taxes',
        'order_total',
        // 'order_total_with_ship',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }


    // public function shipment() // multi tenancy + physical
    // {
    //     return $this->belongsTo(Shipment::class);
    // }
}
