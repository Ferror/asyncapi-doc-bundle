<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema\V3;

class ChannelRenderer
{
    public function render(array $document): array
    {
        $channels = [];

        foreach ($document['channels'] as $channel) {
            $channels[$channel['name']] = [
                'messages' => [
                    $channel['name'] => [
                        '$ref' => '#/components/messages/' . $channel['name'],
                    ]
                ],
            ];
        }

        return $channels;
    }
}
