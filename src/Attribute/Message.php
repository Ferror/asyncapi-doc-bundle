<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;
use Ferror\AsyncapiDocBundle\Schema\V2\ChannelType;

#[Attribute(Attribute::TARGET_CLASS)]
class Message
{
    /**
     * @param array<Property|PropertyArray|PropertyEnum|PropertyObject|PropertyArrayObject> $properties
     */
    public function __construct(
        public readonly string $name,
        public readonly string $channel,
        public array $properties = [],
        public readonly ChannelType $channelType = ChannelType::SUBSCRIBE,
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

    public function addProperty(Property|PropertyArray|PropertyEnum|PropertyObject|PropertyArrayObject $property): void
    {
        $this->properties[] = $property;
    }

    public function enrich(self $self): self
    {
        // UPDATE EXISTING
        foreach ($this->properties as $property) {
            foreach ($self->properties as $selfProperty) {
                $property->enrich($selfProperty);
            }
        }

        // ADD MISSING
        $propertiesNames = array_map(fn ($property) => $property->name, $this->properties);

        foreach ($self->properties as $property) {
            if (!in_array($property->name, $propertiesNames, true)) {
                $this->properties[] = $property;
            }
        }

        return $this;
    }
}
