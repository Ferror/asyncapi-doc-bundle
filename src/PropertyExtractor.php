<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

use Ferror\AsyncapiDocBundle\Attribute\Property;
use Ferror\AsyncapiDocBundle\Attribute\PropertyArray;
use Ferror\AsyncapiDocBundle\Attribute\PropertyArrayObject;
use Ferror\AsyncapiDocBundle\Attribute\PropertyEnum;
use Ferror\AsyncapiDocBundle\Attribute\PropertyInterface;
use Ferror\AsyncapiDocBundle\Attribute\PropertyObject;
use ReflectionClass;

class PropertyExtractor
{
    /**
     * @return iterable<PropertyInterface>
     */
    public function extract(string $class): iterable
    {
        $reflection = new ReflectionClass($class);

        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $propertyAttributes = $property->getAttributes(Property::class);

            if (empty($propertyAttributes)) {
                $propertyAttributes = $property->getAttributes(PropertyEnum::class);
            }

            if (empty($propertyAttributes)) {
                $propertyAttributes = $property->getAttributes(PropertyArray::class);
            }

            if (empty($propertyAttributes)) {
                $propertyAttributes = $property->getAttributes(PropertyObject::class);
            }

            if (empty($propertyAttributes)) {
                $propertyAttributes = $property->getAttributes(PropertyArrayObject::class);
            }

            yield $propertyAttributes[0]->newInstance();
        }
    }
}
