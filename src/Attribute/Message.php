<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;
use Ferror\AsyncapiDocBundle\Schema\ChannelType;

#[Attribute(Attribute::TARGET_CLASS)]
readonly class Message implements PropertyInterface
{
    /**
     * @param PropertyInterface[] $properties
     */
    public function __construct(
        public string $name,
        public string $channel,
        public array $properties = [],
        public ChannelType $channelType = ChannelType::SUBSCRIBE,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'channel' => $this->channel,
            'properties' => array_map(static fn(PropertyInterface $property) => $property->toArray(), $this->properties),
            'channelType' => $this->channelType->value,
        ];
    }
}
