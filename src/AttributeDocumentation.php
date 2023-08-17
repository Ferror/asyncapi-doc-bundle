<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

use Ferror\AsyncapiDocBundle\Attribute\Message;
use Ferror\AsyncapiDocBundle\Attribute\Property;
use Ferror\AsyncapiDocBundle\Tests\UserSignedUp;
use ReflectionAttribute;
use ReflectionClass;

class AttributeDocumentation
{
    public function document(): array
    {
        $reflection = new ReflectionClass(UserSignedUp::class);
        /** @var ReflectionAttribute<Message>[] $messageAttribute */
        $messageAttributes = $reflection->getAttributes(Message::class);
        $properties = $reflection->getProperties();

        $message['name'] = $messageAttributes[0]->newInstance()->name;

        foreach ($properties as $property) {
            /** @var ReflectionAttribute<Property>[] $propertyAttributes */
            $propertyAttributes = $property->getAttributes(Property::class);

            $message['properties'][] = [
                'name' => $propertyAttributes[0]->newInstance()->name,
                'type' => $propertyAttributes[0]->newInstance()->type->value
            ];
        }

        return $message;
    }
}