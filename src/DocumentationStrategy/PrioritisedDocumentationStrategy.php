<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\DocumentationStrategy;

final readonly class PrioritisedDocumentationStrategy
{
    public function __construct(
        public DocumentationStrategyInterface $strategy,
        public int $priority,
    ) {
    }
}
