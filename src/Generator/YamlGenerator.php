<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Generator;

use Ferror\AsyncapiDocBundle\GeneratorInterface;
use Ferror\AsyncapiDocBundle\Schema\V2\SchemaRenderer;
use Symfony\Component\Yaml\Yaml;

final readonly class YamlGenerator implements GeneratorInterface
{
    public function __construct(private SchemaRenderer $generator)
    {
    }

    public function generate(): string
    {
        return Yaml::dump($this->generator->generate(), 10, 2);
    }
}
