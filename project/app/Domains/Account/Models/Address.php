<?php

namespace App\Domains\Account\Models;

use Database\Factories\AddressFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'zip_code',
        'neighborhood',
        'address_city_id',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(AddressCity::class, 'address_city_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'address_id', 'id');
    }

    protected static function newFactory(): AddressFactory
    {
        return AddressFactory::new();
    }
}
