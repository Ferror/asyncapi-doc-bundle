<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;


use Ferror\AsyncapiDocBundle\Attribute\Message;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\PrioritisedDocumentationStrategyInterface;

final readonly class DocumentationEditor
{
    /**
     * @param PrioritisedDocumentationStrategyInterface[] $documentationStrategies
     */
    public function __construct(
        private array $documentationStrategies,
    ) {
    }

    public function document(string $class): Message
    {
        $strategies = [];

        foreach ($this->documentationStrategies as $documentationStrategy) {
            $strategies[$documentationStrategy::getDefaultPriority()] = $documentationStrategy;
        }

        $firstStrategy = array_pop($strategies);

        $documentedMessage = $firstStrategy->document($class);

        foreach ($strategies as $documentationStrategy) {
            $message = $documentationStrategy->document($class);

            $documentedMessage = $documentedMessage->enrich($message);
        }

        return $documentedMessage;
    }
}
