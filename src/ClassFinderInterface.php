<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

interface ClassFinderInterface
{
    public function find(): array;
}