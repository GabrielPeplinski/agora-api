<?php

namespace App\Domains\Account\Models;

use Database\Factories\AddressCityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AddressCity extends Model
{
    use HasFactory;

    protected $table = 'address_cities';

    protected $fillable = [
        'name',
        'address_state_id',
    ];

    public function state(): BelongsTo
    {
        return $this->belongsTo(AddressState::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    protected static function newFactory(): AddressCityFactory
    {
        return AddressCityFactory::new();
    }
}
