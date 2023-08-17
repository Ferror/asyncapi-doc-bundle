<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

use Ferror\AsyncapiDocBundle\Attribute\Message;
use Ferror\AsyncapiDocBundle\Attribute\Property;
use ReflectionAttribute;
use ReflectionClass;

class AttributeDocumentation
{
    public function document(string $class): array
    {
        $reflection = new ReflectionClass($class);
        /** @var ReflectionAttribute<Message>[] $messageAttribute */
        $messageAttributes = $reflection->getAttributes(Message::class);
        $properties = $reflection->getProperties();

        $message = $messageAttributes[0]->newInstance()->toArray();

        foreach ($properties as $property) {
            /** @var ReflectionAttribute<Property>[] $propertyAttributes */
            $propertyAttributes = $property->getAttributes(Property::class);

            $message['properties'][] = $propertyAttributes[0]->newInstance()->toArray();
        }

        return $message;
    }
}