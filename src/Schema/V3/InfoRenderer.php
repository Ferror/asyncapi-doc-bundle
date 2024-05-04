<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema\V3;

final readonly class InfoRenderer
{
    public function __construct(
        public string $title,
        public string $description,
        public string $version,
    ) {
    }

    public function render(): array
    {
        return [
            'title' => $this->title,
            'version' => $this->version,
            'description' => $this->description,
        ];
    }
}
