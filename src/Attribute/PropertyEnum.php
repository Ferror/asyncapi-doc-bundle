<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;
use Ferror\AsyncapiDocBundle\Schema\Format;
use ReflectionEnum;

#[Attribute(Attribute::TARGET_PROPERTY)]
class PropertyEnum extends AbstractProperty implements PropertyInterface
{
    public function __construct(
        string $name,
        public string $enum,
        string $description = '',
        public ?Format $format = null,
        public ?string $example = null,
        public bool $required = true,
    ) {
        parent::__construct($name, $description);
    }

    public function toArray(): array
    {
        $enum = new ReflectionEnum($this->enum);

        return array_merge(parent::toArray(), [
            'type' => 'string',
            'enum' => $enum->getCases(),
            'format' => $this->format?->value,
            'example' => $this->example,
        ]);
    }
}
