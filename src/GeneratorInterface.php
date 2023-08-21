<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

interface GeneratorInterface
{
    public function generate(): string;
}