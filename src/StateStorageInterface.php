<?php

declare(strict_types=1);

namespace TTBooking\UniQuery;

interface StateStorageInterface
{
    public function has(string $id): bool;

    public function get(string $id): State;

    public function put(State $state): State;
}
