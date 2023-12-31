<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

enum DataFormat: string
{
    case YAML = 'yaml';
    case JSON = 'json';
}
