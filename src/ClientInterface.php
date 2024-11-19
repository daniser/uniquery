<?php

declare(strict_types=1);

namespace TTBooking\UniQuery;

interface ClientInterface
{
    /**
     * @template TResult of ResultInterface
     * @template TQuery of QueryInterface<TResult>
     *
     * @phpstan-param TQuery $query
     *
     * @phpstan-return TResult
     *
     * @throws ClientException
     */
    public function query(QueryInterface $query): ResultInterface;
}
