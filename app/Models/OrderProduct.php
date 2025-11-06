<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    /** @use HasFactory<\Database\Factories\OrderProductFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "order_id",
        "product_id"
    ];

    public function order(): BelongsTo {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }
}
