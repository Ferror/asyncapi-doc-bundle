<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\DocumentationStrategy;

use Ferror\AsyncapiDocBundle\Attribute\Property;
use Ferror\AsyncapiDocBundle\Attribute\PropertyArray;
use Ferror\AsyncapiDocBundle\Attribute\PropertyArrayObject;
use Ferror\AsyncapiDocBundle\Attribute\PropertyEnum;
use Ferror\AsyncapiDocBundle\Attribute\PropertyInterface;
use Ferror\AsyncapiDocBundle\Attribute\PropertyObject;
use ReflectionAttribute;
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
            /** @var ReflectionAttribute<Property>[] $propertyAttributes */
            $propertyAttributes = $property->getAttributes(Property::class);

            if (empty($propertyAttributes)) {
                /** @var ReflectionAttribute<PropertyEnum>[] $propertyAttributes */
                $propertyAttributes = $property->getAttributes(PropertyEnum::class);
            }

            if (empty($propertyAttributes)) {
                /** @var ReflectionAttribute<PropertyArray>[] $propertyAttributes */
                $propertyAttributes = $property->getAttributes(PropertyArray::class);
            }

            if (empty($propertyAttributes)) {
                /** @var ReflectionAttribute<PropertyObject>[] $propertyAttributes */
                $propertyAttributes = $property->getAttributes(PropertyObject::class);
            }

            if (empty($propertyAttributes)) {
                /** @var ReflectionAttribute<PropertyArrayObject>[] $propertyAttributes */
                $propertyAttributes = $property->getAttributes(PropertyArrayObject::class);
            }

            if (empty($propertyAttributes)) {
                throw new \RuntimeException('Property attribute not found');
            }

            $propertyAttribute = $propertyAttributes[0]->newInstance();
            $propertyAttribute->name = $property->name;

            yield $propertyAttribute;
        }
    }
}
