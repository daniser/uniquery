<?php

declare(strict_types=1);

namespace TTBooking\UniQuery\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Endpoint
{
    public function __construct(public string $endpoint) {}
}
