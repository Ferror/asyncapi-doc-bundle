<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony\Controller;

use Symfony\Component\HttpFoundation\Response;

readonly class UserInterfaceController
{
    public function __invoke(): Response
    {
        return new Response(
            file_get_contents(__DIR__ . '/../Resources/index.html'),
            200,
            [
                'Content-Type' => 'text/html',
            ]
        );
    }
}
