<?php

namespace App\Models;

use App\Enums\PaymentTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $guarded = ['id'];

    protected $fillable = [
        'customer_id',
        'product_id',
        'payment_type'=> PaymentTransaction::class,
        'quantity',
        'price',
        'sub_total',
        'transaction_date',
    ];

    protected static function booted()
    {
        static::creating(function ($transaction) {
            $transaction->sub_total = $transaction->product->price * $transaction->quantity;
        });

        static::updating(function ($transaction) {
            $transaction->sub_total = $transaction->product->price * $transaction->quantity;
        });
    }


    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
