<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony\Controller;

use Ferror\AsyncapiDocBundle\GeneratorInterface;
use Symfony\Component\HttpFoundation\Response;

final readonly class UserInterfaceController
{
    public function __construct(
        private GeneratorInterface $generator,
    ) {
    }

    public function __invoke(): Response
    {
        $schema = $this->generator->generate();
        $content = <<<HTML
<!DOCTYPE>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Welcome to AsyncAPI!</title>
    </head>
    <body>
        <!-- Remove 'webcomponentsjs' if no support for older browsers is required -->
        <script src="https://unpkg.com/@webcomponents/webcomponentsjs@2.5.0/webcomponents-bundle.js"></script>
        <script src="https://unpkg.com/@asyncapi/web-component@next/lib/asyncapi-web-component.js" defer></script>

        <asyncapi-component
            schema='$schema'
            config='{"show": {"info": false}}'
            schemaFetchOptions='{"method":"GET","mode":"cors"}'
            cssImportPath="https://unpkg.com/@asyncapi/react-component@next/styles/default.min.css">
        </asyncapi-component>
    </body>
</html>
HTML;

        return new Response(
            $content,
            200,
            [
                'Content-Type' => 'text/html',
            ]
        );
    }
}
