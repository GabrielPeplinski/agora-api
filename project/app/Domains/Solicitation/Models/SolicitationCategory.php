<?php

namespace App\Domains\Solicitation\Models;

use Database\Factories\SolicitationCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitationCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    protected static function newFactory(): SolicitationCategoryFactory
    {
        return SolicitationCategoryFactory::new();
    }

    public function solicitations(): HasMany
    {
        return $this->hasMany(Solicitation::class);
    }
}
