<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

interface DocumentationStrategy
{
    public function document(string $class): array;
}