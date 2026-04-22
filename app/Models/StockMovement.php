<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model StockMovement
 *
 * Mencatat setiap pergerakan stok barang (masuk/keluar).
 * - type 'in'  = Barang Masuk (pembelian, restok, return)
 * - type 'out' = Barang Keluar (penjualan, rusak, expired)
 */
class StockMovement extends Model
{
    protected $fillable = [
        'product_id',
        'type',        // 'in' atau 'out'
        'quantity',
        'description',
    ];

    /**
     * Relasi ke Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}