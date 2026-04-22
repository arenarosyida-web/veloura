<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $primaryKey = 'product_id';

    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'image',
        'name',
        'description',
        'price',
        'stock'
    ];

    // relasi ke category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // relasi ke cart items
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    // relasi ke order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    // relasi ke stock movements (barang masuk/keluar)
    public function stockMovements()
    {
        return $this->hasMany(\App\Models\StockMovement::class, 'product_id', 'product_id');
    }


}