<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "name", 
        "email",
        "phone",
        "dob",
        "address",
        "complement",
        "neighbor",
        "neighbor",
        "postal_code",
        "sign_date"
    ];

    protected $casts = [
        "sign_date" => "date"
    ];

    public function orders(): HasMany {
        return $this->hasMany(Order::class);
    }
}
