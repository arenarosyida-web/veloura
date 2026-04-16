<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Payment extends Model
{
    protected $table = 'payments';

    protected $primaryKey = 'payment_id';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'midtrans_order_id',
        'method',
        'amount',
        'status',
        'paid_at'
    ];

    // relasi ke order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}