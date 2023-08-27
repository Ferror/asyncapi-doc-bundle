<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\ClassFinder;

interface ClassFinderInterface
{
    public function find(): array;
}
