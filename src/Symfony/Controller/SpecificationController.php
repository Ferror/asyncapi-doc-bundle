<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony\Controller;

use Ferror\AsyncapiDocBundle\AttributeDocumentation;
use Ferror\AsyncapiDocBundle\Schema;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

class SpecificationController
{
    public function __invoke(): Response
    {
        $documentation = new AttributeDocumentation();
        $gen = new Schema();

        $schema = Yaml::dump(
            [
                'asyncapi' => '2.6.0',
                'info' => [
                    'title' => 'Account Service',
                    'version' => '1.0.0',
                    'description' => 'This service is in charge of processing user signups',
                ],
                'channels' => [
                    'user_signed_up' => [
                        'subscribe' => [
                            'message' => [
                                '$ref' => '#/components/messages/UserSignedUp',
                            ],
                        ],
                    ],
                ],
                'components' => [
                    'messages' => $gen->render($documentation->document()),
                ],
            ],
            10,
            2,
        );

        return new Response(
            $schema,
            200,
            [
                'Content-Type' => 'text/yaml',
            ]
        );
    }
}