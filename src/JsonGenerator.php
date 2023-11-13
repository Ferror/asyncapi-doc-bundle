<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

final readonly class JsonGenerator implements GeneratorInterface
{
    public function __construct(
        private SchemaGenerator $generator,
    ) {
    }

    public function generate(): string
    {
        return json_encode($this->generator->generate(), JSON_THROW_ON_ERROR | JSON_FORCE_OBJECT);
    }
}
