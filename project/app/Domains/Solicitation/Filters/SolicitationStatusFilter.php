<?php

namespace App\Domains\Solicitation\Filters;

use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class SolicitationStatusFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if ($value) {
            return match ($value) {
                SolicitationStatusEnum::OPEN => $this->filterOpenSolicitations($query),
                SolicitationStatusEnum::RESOLVED => $this->filterResolvedSolicitations($query),
                SolicitationStatusEnum::IN_PROGRESS => $this->filterInProgressSolicitations($query),
                default => $query,
            };
        }

        return $query;
    }

    private function filterOpenSolicitations(Builder $query): Builder
    {
        return $query->whereHas('userSolicitations', function ($query) {
            $query->where('status', SolicitationStatusEnum::OPEN)
                ->latest('id');
        });
    }

    private function filterResolvedSolicitations(Builder $query): Builder
    {
        return $query->whereHas('userSolicitations', function ($query) {
            $query->where('status', SolicitationStatusEnum::RESOLVED)
                ->latest('id');
        });
    }

    private function filterInProgressSolicitations(Builder $query): Builder
    {
        return $query->whereHas('userSolicitations', function ($query) {
            $query->where('status', SolicitationStatusEnum::IN_PROGRESS)
                ->latest('id');
        });
    }
}