<?php

namespace App\Domains\Solicitation\Models;

use App\Domains\Account\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Solicitation extends Model
{
    protected $fillable = [
        'title',
        'report',
        'status',
        'latitude_coordinate',
        'longitude_coordinate',
        'user_id',
        'solicitation_category_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function solicitationCategory(): BelongsTo
    {
        return $this->belongsTo(SolicitationCategory::class);
    }

    public function solicitationHistories(): HasMany
    {
        return $this->hasMany(SolicitationHistory::class);
    }
}
