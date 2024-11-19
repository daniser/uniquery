<?php

declare(strict_types=1);

namespace TTBooking\UniQuery\Stores;

use TTBooking\UniQuery\State;
use TTBooking\UniQuery\StateNotFoundException;
use TTBooking\UniQuery\StateStorageInterface;

class NullStorage implements StateStorageInterface
{
    public function has(string $id): bool
    {
        return false;
    }

    public function get(string $id): never
    {
        throw new StateNotFoundException('Null storage is always empty');
    }

    public function put(State $state): State
    {
        return $state;
    }
}
