<?php

declare(strict_types=1);

namespace TTBooking\UniQuery;

final readonly class State
{
    /**
     * @template TResult of ResultInterface
     *
     * @phpstan-param QueryInterface<TResult> $query
     * @phpstan-param TResult                 $result
     */
    public function __construct(
        public string $id,
        public QueryInterface $query,
        public ResultInterface $result,
        public ?string $parentId = null,
    ) {}
}
