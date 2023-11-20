<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony\Controller;

use Ferror\AsyncapiDocBundle\Generator\YamlGenerator;
use Symfony\Component\HttpFoundation\Response;

final readonly class YamlSpecificationController
{
    public function __construct(
        private YamlGenerator $generator,
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
