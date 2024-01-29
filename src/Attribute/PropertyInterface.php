<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

interface PropertyInterface
{
    public function toArray(): array;

    public function enrich(Property|PropertyArray|PropertyEnum|PropertyObject|PropertyArrayObject $property): void;
}
