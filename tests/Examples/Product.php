<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Examples;

final readonly class Product
{
    public function __construct(public string $name)
    {
    }
}
