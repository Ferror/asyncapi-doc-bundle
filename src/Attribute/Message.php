<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Message
{
    /**
     * @param array<Property|PropertyArray|PropertyEnum|PropertyObject|PropertyArrayObject> $properties
     * @param Channel[] $channels
     */
    public function __construct(
        public readonly string $name,
        public array $properties = [],
        public array $channels = [],
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'properties' => array_map(static fn(PropertyInterface $property) => $property->toArray(), $this->properties),
            'channels' => array_map(static fn(Channel $channel) => $channel->toArray(), $this->channels),
        ];
    }

    public function addProperty(Property|PropertyArray|PropertyEnum|PropertyObject|PropertyArrayObject $property): void
    {
        $this->properties[] = $property;
    }

    public function addChannel(Channel $channel): void
    {
        $this->channels[] = $channel;
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
