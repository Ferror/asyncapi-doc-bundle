<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Examples;

final readonly class Payment
{
    public function __construct(public int $id)
    {
    }
}