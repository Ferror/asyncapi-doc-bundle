<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
readonly class Message
{
    public function __construct(
        public string $name,
        public string $channel,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'channel' => $this->channel,
        ];
    }
}