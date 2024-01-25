<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;
use Ferror\AsyncapiDocBundle\Schema\V3\OperationType;

#[Attribute(Attribute::TARGET_CLASS)]
class Operation
{
    public function __construct(
        public string $name,
        public OperationType $type = OperationType::SEND,
    ) {
    }
}
