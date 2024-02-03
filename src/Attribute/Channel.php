<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;
use Ferror\AsyncapiDocBundle\Schema\V2\ChannelType;

#[Attribute(Attribute::TARGET_CLASS)]
readonly class Channel
{
    public function __construct(
        public string $name,
        public ChannelType $type = ChannelType::SUBSCRIBE,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type->value,
        ];
    }
}
