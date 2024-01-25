<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema\V3;

use Ferror\AsyncapiDocBundle\SchemaRendererInterface;
use RuntimeException;

final readonly class SchemaRenderer implements SchemaRendererInterface
{
    public function generate(): array
    {
        throw new RuntimeException("Async API V3 not yet supported");
    }
}
