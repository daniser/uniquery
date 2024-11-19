<?php

declare(strict_types=1);

namespace TTBooking\UniQuery\Stores;

use TTBooking\UniQuery\State;
use TTBooking\UniQuery\StateNotFoundException;
use TTBooking\UniQuery\StateStorageInterface;

class ArrayStorage implements StateStorageInterface
{
    /** @var array<string, State> */
    protected array $states = [];

    public function has(string $id): bool
    {
        return isset($this->states[$id]);
    }

    public function get(string $id): State
    {
        return $this->states[$id] ?? throw new StateNotFoundException("State [$id] not found");
    }

    public function put(State $state): State
    {
        return $this->states[$state->id] = $state;
    }
}
