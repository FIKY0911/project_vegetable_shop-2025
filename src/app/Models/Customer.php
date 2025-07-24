<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    protected $table = 'customers';
    // protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'addres',
    ];

    public function transactions(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
