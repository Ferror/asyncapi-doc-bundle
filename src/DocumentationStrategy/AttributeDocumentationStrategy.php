<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\DocumentationStrategy;

use Ferror\AsyncapiDocBundle\Attribute\Channel;
use Ferror\AsyncapiDocBundle\Attribute\Message;
use Ferror\AsyncapiDocBundle\Attribute\Operation;
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

        /** @var ReflectionAttribute<Operation>[] $operationAttributes */
        $operationAttributes = $reflection->getAttributes(Operation::class);

        /** @var ReflectionAttribute<Channel>[] $channelAttributes */
        $channelAttributes = $reflection->getAttributes(Channel::class);

        $message = $messageAttributes[0]->newInstance();
        $operation = $operationAttributes[0]->newInstance();
        $channel = $channelAttributes[0]->newInstance();

        $operation->addChannel($channel);

        foreach ($this->propertyExtractor->extract($class) as $property) {
            $message->addProperty($property);
        }

        // Channels are optional as it's possible to document just Messages.
        /** @var ReflectionAttribute<Channel>[] $messageAttributes */
        $channelAttributes = $reflection->getAttributes(Channel::class);

        foreach ($channelAttributes as $channelAttribute) {
            $message->addChannel($channelAttribute->newInstance());
        }

        return $message;
    }
}
