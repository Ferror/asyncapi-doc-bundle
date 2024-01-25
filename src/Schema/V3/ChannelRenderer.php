<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema\V3;

class ChannelRenderer
{
    public function render(array $document): array
    {
        $channel[$document['channel']] = [
            $document['channelType'] => [
                'message' => [
                    '$ref' => '#/components/messages/' . $document['name'],
                ],
            ],
        ];

        return $channel;
    }
}
