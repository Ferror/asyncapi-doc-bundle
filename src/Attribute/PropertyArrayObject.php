<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;
use Ferror\AsyncapiDocBundle\Format;
use Ferror\AsyncapiDocBundle\PropertyType;
use Ferror\AsyncapiDocBundle\PropertyTypeTranslator;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_CLASS)]
readonly class PropertyArrayObject implements PropertyInterface
{
    public function __construct(
        public string $name,
        public string $class,
        public string $description = '',
        public ?Format $format = null,
        public ?string $example = null,
        public bool $required = true,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'type' => 'array',
            'description' => $this->description,
            'format' => $this->format?->value,
            'example' => $this->example,
        ];
    }
}