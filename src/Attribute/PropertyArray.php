<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;
use Ferror\AsyncapiDocBundle\Schema\Format;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_CLASS)]
readonly class PropertyArray implements PropertyInterface
{
    public function __construct(
        public string $name,
        public string $itemsType,
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