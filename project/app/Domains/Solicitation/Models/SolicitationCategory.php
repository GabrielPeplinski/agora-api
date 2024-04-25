<?php

namespace App\Domains\Solicitation\Models;

use Database\Factories\Domains\Solicitation\SolicitationCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SolicitationCategory extends Model
{
    use HasFactory;

    protected $table = 'solicitation_categories';

    protected $fillable = [
        'name',
        'description',
    ];

    public function solicitations(): HasMany
    {
        return $this->hasMany(Solicitation::class);
    }

    protected static function newFactory(): SolicitationCategoryFactory
    {
        return SolicitationCategoryFactory::new();
    }
}
