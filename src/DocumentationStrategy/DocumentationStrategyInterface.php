<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\DocumentationStrategy;

interface DocumentationStrategyInterface
{
    /**
     * @param class-string $class
     */
    public function document(string $class): array;
}
