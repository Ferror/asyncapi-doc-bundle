<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;
use Ferror\AsyncapiDocBundle\PropertyTypeTranslator;
use Ferror\AsyncapiDocBundle\Schema\Format;
use Ferror\AsyncapiDocBundle\Schema\PropertyType;
use InvalidArgumentException;
use ReflectionEnum;
use ReflectionEnumBackedCase;
use ReflectionException;

#[Attribute(Attribute::TARGET_PROPERTY)]
class PropertyEnum extends AbstractProperty
{
    public function __construct(
        string $name,
        public string $enum,
        string $description = '',
        public ?Format $format = null,
        public ?string $example = null,
        bool $required = true,
    ) {
        parent::__construct($name, $description, $required);
    }

    /**
     * @throws ReflectionException
     */
    public function toArray(): array
    {
        $enum = new ReflectionEnum($this->enum);

        if (!$enum->isBacked()) {
            throw new InvalidArgumentException('Only Backend Enum can be documented');
        }

        return array_merge(parent::toArray(), [
            'type' => PropertyTypeTranslator::translate($enum->getBackingType()->getName()),
            'enum' => array_map(
                static fn (ReflectionEnumBackedCase $case) => $case->getBackingValue(),
                $enum->getCases()
            ),
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

            if (empty($this->example)) {
                $this->example = $property->example;
            }
        }
    }
}
