<?php

namespace App\Support;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class PaginationBuilder extends QueryBuilder implements Responsable
{
    public const PER_PAGE_DEFAULT = 10;

    private int $perPage = self::PER_PAGE_DEFAULT;

    private $resource;

    public static function new(): self
    {
        return new static(...func_get_args());
    }

    private function getPerPage()
    {
        $perPage = \Request::input('perPage', $this->perPage);
        if ($perPage > 100 || $perPage < 1) {
            $message = "Per page parameter [{$perPage}] out of the range.";
            throw new UnauthorizedHttpException($message);
        }

        return $perPage;
    }

    public function perPage(int $perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function criteria(mixed $criteria): self
    {
        if (is_iterable($criteria)) {
            foreach ($criteria as $criterion) {
                $criterion->apply($this);
            }

            return $this;
        }

        $criteria->apply($this);

        return $this;
    }

    public function resource($resource): static
    {
        $this->resource = $resource;

        return $this;
    }

    public function build(): AnonymousResourceCollection
    {
        $paginated = $this->paginate($this->getPerPage())
            ->appends(request()->query());

        return ($this->resource)
            ? $this->resource::collection($paginated)
            : JsonResource::collection($paginated);
    }

    public function toResponse($request): JsonResponse
    {
        return $this->build()
            ->response();
    }
}
