<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\DocumentationStrategy;

use Ferror\AsyncapiDocBundle\Attribute\Message;
use Ferror\AsyncapiDocBundle\PropertyExtractor;
use ReflectionAttribute;
use ReflectionClass;

readonly class AttributeDocumentationStrategy implements DocumentationStrategyInterface
{
    public function __construct(
        private PropertyExtractor $propertyExtractor = new PropertyExtractor(),
    ) {
    }

    /**
     * @param class-string $class
     */
    public function document(string $class): array
    {
        $reflection = new ReflectionClass($class);
        /** @var ReflectionAttribute<Message>[] $messageAttributes */
        $messageAttributes = $reflection->getAttributes(Message::class);

        if (empty($messageAttributes)) {
            throw new DocumentationStrategyException();
        }

        $message = $messageAttributes[0]->newInstance()->toArray();

        foreach ($this->propertyExtractor->extract($class) as $property) {
            $message['properties'][] = $property->toArray();
        }

        return $message;
    }
}