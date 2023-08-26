<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema;

enum ChannelType: string
{
    case PUBLISH = 'publish';
    case SUBSCRIBE = 'subscribe';
}