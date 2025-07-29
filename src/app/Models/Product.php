<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{

    use HasFactory;

    protected $table = 'products';
    protected $guarded = ['id'];

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'stock',
        'description',
        'image',
        'is_active',
    ];

    public function isStockAvailable(int $quantity): bool
    {
        return $this->stock >= $quantity;
    }

    /**
     * Relasi: Produk dimiliki oleh satu Customer
     */

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

}
