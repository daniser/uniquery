<?php

declare(strict_types=1);

namespace TTBooking\UniQuery;

interface StateFactoryInterface
{
    /**
     * @template TResult of ResultInterface
     *
     * @phpstan-param QueryInterface<TResult> $query
     * @phpstan-param TResult                 $result
     */
    public function make(QueryInterface $query, ResultInterface $result, ?State $parent = null): State;
}
