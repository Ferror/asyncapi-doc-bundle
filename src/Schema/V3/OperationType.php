<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema\V3;

enum OperationType: string
{
    case SEND = 'send';
    case RECEIVE = 'receive';
}

