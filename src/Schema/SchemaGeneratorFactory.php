<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema;

use Ferror\AsyncapiDocBundle\Schema\V2\SchemaRenderer;
use Ferror\AsyncapiDocBundle\SchemaRendererInterface;
use InvalidArgumentException;

final readonly class SchemaGeneratorFactory
{
    public function __construct(
        private SchemaRenderer $schemaGeneratorV2,
    ) {
    }

    public function __invoke(string $version): SchemaRendererInterface
    {
        [$major, $minor, $patch] = explode('.', $version);

        if ($major === '2') {
            return $this->schemaGeneratorV2;
        }

        throw new InvalidArgumentException("Not supported Async API Schema $version");
    }
}
