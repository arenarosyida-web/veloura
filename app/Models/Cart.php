<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CartItem;
use App\Models\User;

class Cart extends Model
{
    protected $table = 'carts';

    protected $primaryKey = 'cart_id';

    public $timestamps = false;

    protected $fillable = [
        'user_id'
    ];

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // relasi ke cart items
    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }
}