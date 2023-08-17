<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;
use Ferror\AsyncapiDocBundle\PropertyType;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_CLASS)]
readonly class Property
{
    public function __construct(
        public string $name,
        public PropertyType $type,
        public string $description,
        public string $format,
        public string $example,
    ) {
    }
}