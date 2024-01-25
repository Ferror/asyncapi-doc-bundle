<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema\V3;

final readonly class InfoRenderer
{
    public function render(array $document): array
    {
        return [
            'title' => $document['title'],
            'version' => $document['version'],
            'description' => $document['description'],
        ];
    }
}
