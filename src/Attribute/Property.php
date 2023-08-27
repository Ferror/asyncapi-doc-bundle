<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;
use Ferror\AsyncapiDocBundle\Schema\Format;
use Ferror\AsyncapiDocBundle\Schema\PropertyType;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Property extends AbstractProperty implements PropertyInterface
{
    public function __construct(
        string $name,
        string $description = '',
        public readonly PropertyType $type = PropertyType::STRING,
        public readonly ?Format $format = null,
        public readonly ?string $example = null,
        public readonly bool $required = true,
    ) {
        parent::__construct($name, $description);
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
