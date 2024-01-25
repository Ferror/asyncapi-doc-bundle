<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Generator;

use Ferror\AsyncapiDocBundle\DataFormat;
use Ferror\AsyncapiDocBundle\GeneratorInterface;
use Ferror\AsyncapiDocBundle\Schema\V2\SchemaRenderer;

final readonly class GeneratorFactory
{
    public function __construct(private SchemaRenderer $generator)
    {
    }

    public function create(DataFormat $format): GeneratorInterface
    {
        if ($format === DataFormat::YAML) {
            return new YamlGenerator($this->generator);
        }

        if ($format === DataFormat::JSON) {
            return new JsonGenerator($this->generator);
        }
    }
}
