<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Symfony\Controller;

use Ferror\AsyncapiDocBundle\AttributeDocumentation;
use Ferror\AsyncapiDocBundle\ClassFetcher;
use Ferror\AsyncapiDocBundle\Schema;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

class SpecificationController
{
    public function __invoke(): Response
    {
        $finder = new ClassFetcher();
        $documentation = new AttributeDocumentation();
        $gen = new Schema();

        $classes = $finder->get();

        $channels = [];
        $messages = [];

        foreach ($classes as $class) {
            $document = $documentation->document($class);
            $channel = $gen->renderChannels($document);
            $message = $gen->render($document);

            $channelKey = key($channel);
            $messageKey = key($message);

            $channels[$channelKey] = $channel[$channelKey];
            $messages[$messageKey] = $message[$messageKey];
        }

        $schema = Yaml::dump(
            [
                'asyncapi' => '2.6.0',
                'info' => [
                    'title' => 'Account Service',
                    'version' => '1.0.0',
                    'description' => 'This service is in charge of processing user signups',
                ],
                'channels' => $channels,
                'components' => [
                    'messages' => $messages,
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