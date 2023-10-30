<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

use Ferror\AsyncapiDocBundle\DocumentationStrategy\PrioritisedDocumentationStrategy;

final readonly class DocumentationEditor
{
    /**
     * @param PrioritisedDocumentationStrategy[] $documentationStrategies
     */
    public function __construct(
        private array $documentationStrategies,
    ) {
    }

    public function document(string $class): array
    {
        $result = [];
        $strategies = [];

        foreach ($this->documentationStrategies as $documentationStrategy) {
            $strategies[$documentationStrategy->priority] = $documentationStrategy->strategy;
        }

        foreach ($strategies as $documentationStrategy) {
            $result = array_merge($result, $documentationStrategy->document($class));
        }

        return $result;
    }
}
