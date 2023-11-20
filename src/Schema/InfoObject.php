<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema;

final readonly class InfoObject
{
    public function __construct(
        public string $title,
        public string $description,
        public string $version,
    ) {
    }
}
