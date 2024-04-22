<?php

namespace App\Domains\Solicitation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Solicitation extends Model
{
    protected $table = 'solicitations';

    protected $fillable = [
        'solicitation_category_id',
        'title',
        'description',
        'latitude_coordinates',
        'longitude_coordinates',
        'likes_amount',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(SolicitationCategory::class, 'solicitation_category_id');
    }

    public function userSolicitations(): HasMany
    {
        return $this->hasMany(UserSolicitation::class);
    }

    public function getStatusAttribute(): string
    {
        return $this->userSolicitations()
            ->latest()
            ->first()
            ->status;
    }
}
