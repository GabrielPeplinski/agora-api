<?php

namespace App\Domains\Account\Models;

use Database\Factories\AddressFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'zip_code',
        'neighborhood',
        'city_id',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(AddressCity::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    protected static function newFactory(): AddressFactory
    {
        return AddressFactory::new();
    }
}
