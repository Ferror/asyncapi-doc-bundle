<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

use Ferror\AsyncapiDocBundle\ClassFinder\ClassFinderInterface;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\DocumentationStrategyInterface;
use Ferror\AsyncapiDocBundle\Schema\InfoObject;

final readonly class SchemaGenerator
{
    public function __construct(
        private ClassFinderInterface $classFinder,
        private DocumentationStrategyInterface $documentationStrategy,
        private Schema $schema,
        private array $servers,
        private InfoObject $infoObject,
        private string $asyncApiVersion = '2.6.0'
    ) {
    }

    public function generate(): array
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

        return [
            'asyncapi' => $this->asyncApiVersion,
            'info' => [
                'title' => $this->infoObject->title,
                'version' => $this->infoObject->version,
                'description' => $this->infoObject->description,
            ],
            'servers' => $this->servers,
            'channels' => $channels,
            'components' => [
                'messages' => $messages,
            ],
        ];
    }
}
