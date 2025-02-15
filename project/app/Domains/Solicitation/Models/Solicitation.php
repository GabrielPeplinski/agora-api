<?php

namespace App\Domains\Solicitation\Models;

use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use Database\Factories\Domains\Solicitation\SolicitationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Solicitation extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'solicitations';

    protected $fillable = [
        'solicitation_category_id',
        'title',
        'description',
        'latitude_coordinates',
        'longitude_coordinates',
        'likes_count',
        'current_status',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(SolicitationCategory::class, 'solicitation_category_id');
    }

    public function userSolicitations(): HasMany
    {
        return $this->hasMany(UserSolicitation::class);
    }

    protected static function newFactory(): SolicitationFactory
    {
        return SolicitationFactory::new();
    }

    public function likes(): HasMany
    {
        return $this->userSolicitations()
            ->where(
                'action_description',
                SolicitationActionDescriptionEnum::LIKE
            );
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('coverImage')
            ->singleFile();

        $this->addMediaCollection('images');
    }
}
