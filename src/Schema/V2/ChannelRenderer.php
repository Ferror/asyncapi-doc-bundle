<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema\V2;

class ChannelRenderer
{
    public function render(array $document): array
    {
        $channels = [];

        foreach ($document['channels'] as $channel) {
            $channels[$channel['name']] = [
                $channel['type'] => [
                    'message' => [
                        '$ref' => '#/components/messages/' . $document['name'],
                    ],
                ],
            ];
        }

        return $channels;
    }
}
