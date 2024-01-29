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
        $result = [];
        $strategies = [];

        foreach ($this->documentationStrategies as $documentationStrategy) {
            $strategies[$documentationStrategy::getDefaultPriority()] = $documentationStrategy;
        }

        foreach ($strategies as $documentationStrategy) {
            return $documentationStrategy->document($class);
        }
    }
}
