<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\DocumentationStrategy;

interface PrioritisedDocumentationStrategyInterface extends DocumentationStrategyInterface
{
    public static function getDefaultPriority(): int;
}
