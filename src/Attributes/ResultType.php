<?php

declare(strict_types=1);

namespace TTBooking\UniQuery\Attributes;

use Attribute;
use TTBooking\UniQuery\ResultInterface;

/**
 * @template TResult of ResultInterface
 */
#[Attribute(Attribute::TARGET_CLASS)]
class ResultType
{
    /**
     * @param class-string<TResult> $type
     */
    public function __construct(public string $type) {}
}
