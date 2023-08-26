<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

use Ferror\AsyncapiDocBundle\Attribute\Message;
use Ferror\AsyncapiDocBundle\Attribute\Property;
use Ferror\AsyncapiDocBundle\Attribute\PropertyInterface;
use ReflectionAttribute;
use ReflectionClass;

class AttributeDocumentationStrategy implements DocumentationStrategyInterface
{
    public function __construct(private PropertyExtractor $propertyExtractor = new PropertyExtractor())
    {
    }

    /**
     * @param class-string $class
     */
    public function document(string $class): array
    {
        $reflection = new ReflectionClass($class);
        /** @var ReflectionAttribute<Message>[] $messageAttribute */
        $messageAttributes = $reflection->getAttributes(Message::class);

        $message = $messageAttributes[0]->newInstance()->toArray();

        foreach ($this->propertyExtractor->extract($class) as $property) {
            $message['properties'][] = $property->toArray();
        }

        return $message;
    }
}