<?php

declare(strict_types=1);

namespace TTBooking\UniQuery;

use Iterator;

/**
 * @implements Iterator<string, State>
 */
class StateIterator implements Iterator
{
    protected State $current;

    protected bool $valid = true;

    public function __construct(protected State $state, protected StateStorageInterface $store)
    {
        $this->current = $state;
    }

    public function current(): State
    {
        return $this->current;
    }

    public function next(): void
    {
        $this->valid = isset($this->current->parentId);
        if (isset($this->current->parentId)) {
            $this->current = $this->store->get($this->current->parentId);
        }
    }

    public function key(): string
    {
        return $this->current->id;
    }

    public function valid(): bool
    {
        return $this->valid;
    }

    public function rewind(): void
    {
        $this->current = $this->state;
        $this->valid = true;
    }
}
