<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;
use Ferror\AsyncapiDocBundle\Schema\Format;
use Ferror\AsyncapiDocBundle\Schema\PropertyType;

#[Attribute(Attribute::TARGET_PROPERTY)]
class PropertyArray extends AbstractProperty implements PropertyInterface
{
    public function __construct(
        string $name,
        public readonly PropertyType $itemsType,
        string $description = '',
        public readonly ?Format $format = null,
        public readonly ?string $example = null,
        bool $required = true,
    ) {
        parent::__construct($name, $description, $required);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'type' => 'array',
            'format' => $this->format?->value,
            'example' => $this->example,
            'itemsType' => $this->itemsType->value,
        ]);
    }
}
