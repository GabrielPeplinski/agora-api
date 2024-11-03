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
            '(6371000 * acos(cos(radians(?)) * cos(radians(latitude_coordinates::float)) * cos(radians(longitude_coordinates::float) - radians(?)) + sin(radians(?)) * sin(radians(latitude_coordinates::float)))) < ?',
            [$latitude, $longitude, $latitude, $radius]
        );
    }
}
