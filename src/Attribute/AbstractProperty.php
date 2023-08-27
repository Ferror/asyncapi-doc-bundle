<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

abstract class AbstractProperty
{
    public function __construct(
        public string $name,
        public string $description,
    ) {
    }
}
