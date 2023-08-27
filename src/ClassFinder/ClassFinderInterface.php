<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\ClassFinder;

interface ClassFinderInterface
{
    /**
     * @return class-string[]
     */
    public function find(): array;
    /**
     * @return class-string[]
     */
    public function filter(callable $callable): array;
}
