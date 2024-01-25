<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

interface SchemaRendererInterface
{
    public function generate(): array;
}
