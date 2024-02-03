<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Generator;

use Ferror\AsyncapiDocBundle\GeneratorInterface;
use Ferror\AsyncapiDocBundle\SchemaRendererInterface;
use Symfony\Component\Yaml\Yaml;

final readonly class YamlGenerator implements GeneratorInterface
{
    public function __construct(private SchemaRendererInterface $generator)
    {
    }

    public function generate(): string
    {
        return Yaml::dump($this->generator->generate(), 10, 2);
    }
}
