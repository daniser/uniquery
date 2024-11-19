<?php

declare(strict_types=1);

namespace TTBooking\UniQuery;

use Symfony\Component\Uid\UuidV7;

class UuidStateFactory implements StateFactoryInterface
{
    public function make(QueryInterface $query, ResultInterface $result, ?State $parent = null): State
    {
        return new State((string) new UuidV7, $query, $result, $parent?->id);
    }
}
