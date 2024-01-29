<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\DocumentationStrategy;

use Ferror\AsyncapiDocBundle\Attribute\Message;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;

final readonly class AttributeDocumentationStrategy implements PrioritisedDocumentationStrategyInterface
{
    public function __construct(
        private PropertyExtractor $propertyExtractor = new PropertyExtractor(),
    ) {
    }

    public static function getDefaultPriority(): int
    {
        return 10;
    }

    /**
     * @throws DocumentationStrategyException
     * @throws ReflectionException
     */
    public function document(string $class): Message
    {
        $reflection = new ReflectionClass($class);
        /** @var ReflectionAttribute<Message>[] $messageAttributes */
        $messageAttributes = $reflection->getAttributes(Message::class);

        if (empty($messageAttributes)) {
            throw new DocumentationStrategyException('Error: class ' . $class . ' must have at least ' . Message::class . ' attribute.');
        }

        $message = $messageAttributes[0]->newInstance();

        foreach ($this->propertyExtractor->extract($class) as $property) {
            $message->addProperty($property);
        }

        return $message;
    }
}
