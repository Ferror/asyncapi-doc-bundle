<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

use Symfony\Component\Yaml\Yaml;

final readonly class YamlGenerator implements GeneratorInterface
{
    public function __construct(
        private SchemaGenerator $generator,
    ) {
    }

    public function generate(): string
    {
        return Yaml::dump($this->generator->generate(), 10, 2);
    }
}
