<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_CLASS)]
readonly class PropertyObject implements PropertyInterface
{
    public function __construct(
        public string $name,
        public string $class,
        public string $description = '',
        public array $items = [],
        public bool $required = true,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'type' => 'object',
            'description' => $this->description,
            'items' => array_map(static fn(PropertyInterface $property) => $property->toArray(), $this->items),
        ];
    }
}
