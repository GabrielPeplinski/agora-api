<?php

namespace App\Domains\Solicitation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SolicitationCategory extends Model
{
    protected $table = 'solicitation_categories';

    protected $fillable = [
        'name',
        'description',
    ];

    public function solicitations(): HasMany
    {
        return $this->hasMany(Solicitation::class);
    }
}
