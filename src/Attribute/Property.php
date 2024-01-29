<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;
use Ferror\AsyncapiDocBundle\Schema\Format;
use Ferror\AsyncapiDocBundle\Schema\PropertyType;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Property extends AbstractProperty
{
    public function __construct(
        string $name,
        string $description = '',
        public PropertyType $type = PropertyType::STRING,
        public ?Format $format = null,
        public ?string $example = null,
        bool $required = true,
    ) {
        parent::__construct($name, $description, $required);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'type' => $this->type->value,
            'format' => $this->format?->value,
            'example' => $this->example,
        ]);
    }

    public function enrich(Property|PropertyArray|PropertyEnum|PropertyObject|PropertyArrayObject $property): void
    {
        if ($property->name === $this->name && $property::class === $this::class) {
            if (empty($this->format)) {
                $this->format = $property->format;
            }

            if ($this->type !== $property->type && $this->type === PropertyType::STRING) {
                $this->type = $property->type;
            }

            if (empty($this->example)) {
                $this->example = $property->example;
            }
        }
    }
}
