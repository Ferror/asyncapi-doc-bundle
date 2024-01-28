<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\DocumentationStrategy;

use Ferror\AsyncapiDocBundle\Attribute\Message;

interface DocumentationStrategyInterface
{
    /**
     * @param class-string $class
     */
    public function document(string $class): Message;
}
