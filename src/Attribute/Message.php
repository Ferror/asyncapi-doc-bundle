<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Attribute;

use Attribute;
use Ferror\AsyncapiDocBundle\ChannelType;

#[Attribute(Attribute::TARGET_CLASS)]
readonly class Message
{
    public function __construct(
        public string $name,
        public string $channel,
        public ChannelType $channelType = ChannelType::SUBSCRIBE,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'channel' => $this->channel,
            'channelType' => $this->channelType->value,
        ];
    }
}