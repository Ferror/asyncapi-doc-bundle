<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema\V3;

final readonly class ServerRenderer
{
    public function __construct(private array $servers)
    {
    }

    public function render(): array
    {
        $servers = [];

        foreach ($this->servers as $name => $properties) {
            $url = $properties['url'];
            unset($properties['url']);
            $properties['host'] = $url;

            $servers[$name] = $properties;
        }

        return $servers;
    }
}
