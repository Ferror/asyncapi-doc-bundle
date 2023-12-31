<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

use Ferror\AsyncapiDocBundle\Generator\JsonGenerator;
use Ferror\AsyncapiDocBundle\Generator\YamlGenerator;
use InvalidArgumentException;

final readonly class GeneratorFactory
{
    public function __construct(private SchemaGenerator $generator)
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
