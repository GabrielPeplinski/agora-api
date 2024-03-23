<?php

namespace App\Domains\Solicitation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitationCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    public function solicitations(): HasMany
    {
        return $this->hasMany(Solicitation::class);
    }
}
