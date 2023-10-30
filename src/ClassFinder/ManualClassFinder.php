<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\ClassFinder;

final readonly class ManualClassFinder implements ClassFinderInterface
{
    public function __construct(
        private array $classes = [],
    ) {
    }

    /**
     * @return class-string[]
     */
    public function find(): array
    {
        return $this->classes;
    }

    /**
     * @return class-string[]
     */
    public function filter(callable $callable): array
    {
        return array_values(array_filter($this->classes, $callable));
    }
}
