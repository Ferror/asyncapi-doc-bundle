<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema\V3;

final readonly class ChannelRenderer
{
    public function render(array $document): array
    {
        $channels = [];

        foreach ($document['channels'] as $channel) {
            $channels[$channel['name']] = [
                'messages' => [
                    $document['name'] => [
                        '$ref' => '#/components/messages/' . $document['name'],
                    ]
                ],
            ];
        }

        return $channels;
    }
}
