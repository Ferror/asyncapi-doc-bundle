<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

enum ChannelType: string
{
    case PUBLISH = 'publish';
    case SUBSCRIBE = 'subscribe';
}