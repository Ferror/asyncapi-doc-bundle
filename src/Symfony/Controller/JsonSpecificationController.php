<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony\Controller;

use Ferror\AsyncapiDocBundle\JsonGenerator;
use Symfony\Component\HttpFoundation\Response;

final readonly class JsonSpecificationController
{
    public function __construct(
        private JsonGenerator $generator,
    ) {
    }

    public function __invoke(): Response
    {
        return new Response(
            $this->generator->generate(),
            200,
            [
                'Content-Type' => 'text/json',
            ]
        );
    }
}
