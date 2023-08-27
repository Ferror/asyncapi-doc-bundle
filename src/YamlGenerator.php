<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

use Ferror\AsyncapiDocBundle\ClassFinder\ClassFinderInterface;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\DocumentationStrategyInterface;
use Symfony\Component\Yaml\Yaml;

readonly class YamlGenerator implements GeneratorInterface
{
    public function __construct(
        private ClassFinderInterface $classFinder,
        private DocumentationStrategyInterface $documentationStrategy,
        private Schema $schema,
    ) {
    }

    public function generate(): string
    {
        $classes = $this->classFinder->find();

        $channels = [];
        $messages = [];

        foreach ($classes as $class) {
            $document = $this->documentationStrategy->document($class);
            $channel = $this->schema->renderChannels($document);
            $message = $this->schema->render($document);

            $channelKey = key($channel);
            $messageKey = key($message);

            $channels[$channelKey] = $channel[$channelKey];
            $messages[$messageKey] = $message[$messageKey];
        }

        return Yaml::dump(
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
    }
}