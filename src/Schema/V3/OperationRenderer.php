<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema\V3;

final readonly class OperationRenderer
{
    public function render(array $document): array
    {
        $operations = [];

        foreach ($document['operations'] as $operation) {
            foreach ($operation['channels'] as $channel) {
                $operations[$operation['name']] = [
                    'action' => $operation['type'],
                    'channel' => [
                         '$ref' => '#/channels/' . $channel['name'],
                    ],
                ];
            }
        }

        return $operations;
    }
}
