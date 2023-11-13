<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony\Controller;

use Ferror\AsyncapiDocBundle\GeneratorInterface;
use Symfony\Component\HttpFoundation\Response;

final readonly class UserInterfaceController
{
    public function __construct(
        private GeneratorInterface $generator,
        private string $componentVersion = 'next',
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
        <script src="https://unpkg.com/@asyncapi/web-component@{$this->componentVersion}/lib/asyncapi-web-component.js" defer></script>

        <asyncapi-component
          schema='$schema'
          config='{"show": {"info": true}}'
          cssImportPath="https://unpkg.com/@asyncapi/react-component@{$this->componentVersion}/styles/default.min.css"
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
