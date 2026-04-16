<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Payment; // ← tambahkan ini

class Order extends Model
{
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'receiver_name',
        'phone',
        'full_address',
        'total_price',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    // ← tambahkan ini
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'order_id');
    }
}