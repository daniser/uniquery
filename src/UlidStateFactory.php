<?php

declare(strict_types=1);

namespace TTBooking\UniQuery;

use Symfony\Component\Uid\Ulid;

class UlidStateFactory implements StateFactoryInterface
{
    public function make(QueryInterface $query, ResultInterface $result, ?State $parent = null): State
    {
        return new State((string) new Ulid, $query, $result, $parent?->id);
    }
}
