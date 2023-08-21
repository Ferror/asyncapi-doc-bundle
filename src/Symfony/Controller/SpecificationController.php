<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony\Controller;

use Ferror\AsyncapiDocBundle\Generator;
use Symfony\Component\HttpFoundation\Response;

readonly class SpecificationController
{
    public function __construct(
        private Generator $generator,
    ) {
    }

    public function __invoke(): Response
    {
        return new Response(
            $this->generator->generate(),
            200,
            [
                'Content-Type' => 'text/yaml',
            ]
        );
    }
}