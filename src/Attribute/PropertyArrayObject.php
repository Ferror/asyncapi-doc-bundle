<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;
use Ferror\AsyncapiDocBundle\Schema\Format;

#[Attribute(Attribute::TARGET_PROPERTY)]
class PropertyArrayObject extends AbstractProperty implements PropertyInterface
{
    public function __construct(
        string $name,
        public string $class,
        string $description = '',
        public ?Format $format = null,
        public ?string $example = null,
        public bool $required = true,
    ) {
        parent::__construct($name, $description);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'type' => 'array',
            'format' => $this->format?->value,
            'example' => $this->example,
        ]);
    }
}
