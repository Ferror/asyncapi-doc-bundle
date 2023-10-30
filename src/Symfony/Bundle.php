<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony;

use Symfony\Component\HttpKernel\Bundle\Bundle as SymfonyBundle;

class Bundle extends SymfonyBundle
{
    public function getContainerExtension(): Extension
    {
        return new Extension();
    }
}
