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
        public array $channels = [],
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type->value,
            'channels' => array_map(
                static fn (Channel $channel) => $channel->toArray(),
                $this->channels
            ),
        ];
    }
}
