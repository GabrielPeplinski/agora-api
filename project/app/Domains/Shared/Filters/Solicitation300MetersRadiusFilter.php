<?php

namespace App\Domains\Shared\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class Solicitation300MetersRadiusFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if (is_array($value)) {
            $value = implode(',', $value);
        }

        [$latitude, $longitude] = array_map('floatval', explode(',', $value));
        $radius = 300;

        return $query->whereRaw(
            '(6371000 * 2 * ASIN(SQRT(POWER(SIN(RADIANS(? - latitude_coordinates::float) / 2), 2) + COS(RADIANS(?)) * COS(RADIANS(latitude_coordinates::float)) * POWER(SIN(RADIANS(? - longitude_coordinates::float) / 2), 2)))) < ?',
            [$latitude, $latitude, $longitude, $radius]
        );
    }
}
