<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;
use Ferror\AsyncapiDocBundle\Format;

#[Attribute(Attribute::TARGET_PROPERTY)]
class PropertyEnum implements PropertyInterface
{
    public function __construct(
        public string $name,
        public string $enum,
        public string $description = '',
        public ?Format $format = null,
        public ?string $example = null,
        public bool $required = true,
    ) {
    }

    public function toArray(): array
    {
        $refl = new \ReflectionEnum($this->enum);

        return [
            'name' => $this->name,
            'type' => 'string',
            'enum' => $refl->getCases(),
            'description' => $this->description,
            'format' => $this->format?->value,
            'example' => $this->example,
        ];
    }
}
