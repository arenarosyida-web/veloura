<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Cart;

class CartItem extends Model
{
    protected $table = 'cart_items';

    protected $primaryKey = 'cart_item_id';

    public $timestamps = false;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
}