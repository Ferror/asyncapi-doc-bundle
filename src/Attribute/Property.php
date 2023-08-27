<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;
use Ferror\AsyncapiDocBundle\PropertyTypeTranslator;
use Ferror\AsyncapiDocBundle\Schema\Format;
use Ferror\AsyncapiDocBundle\Schema\PropertyType;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_CLASS)]
readonly class Property implements PropertyInterface
{
    public function __construct(
        public string $name,
        public PropertyType $type = PropertyType::STRING,
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
            'type' => $this->type->value,
            'description' => $this->description,
            'format' => $this->format?->value,
            'example' => $this->example,
        ];
    }
}
