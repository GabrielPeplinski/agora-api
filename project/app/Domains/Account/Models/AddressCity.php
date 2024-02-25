<?php

namespace App\Domains\Account\Models;

use Database\Factories\AddressCityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AddressCity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'state_id',
    ];

    public function state(): BelongsTo
    {
        return $this->belongsTo(AddressState::class);
    }

    protected static function newFactory(): AddressCityFactory
    {
        return AddressCityFactory::new();
    }
}
