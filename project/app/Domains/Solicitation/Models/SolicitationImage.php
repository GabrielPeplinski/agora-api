<?php

namespace App\Domains\Solicitation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitationImage extends Model
{
    protected $table = 'solicitation_images';

    protected $fillable = [
        'solicitation_id',
        'file_name',
        'file_path',
        'is_cover_image',
    ];

    public function solicitation(): BelongsTo
    {
        return $this->belongsTo(Solicitation::class);
    }
}
