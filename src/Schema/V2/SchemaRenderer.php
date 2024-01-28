<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema\V2;

use Ferror\AsyncapiDocBundle\ClassFinder\ClassFinderInterface;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\DocumentationStrategyInterface;
use Ferror\AsyncapiDocBundle\SchemaRendererInterface;

final readonly class SchemaRenderer implements SchemaRendererInterface
{
    public function __construct(
        private ClassFinderInterface $classFinder,
        private DocumentationStrategyInterface $documentationStrategy,
        private ChannelRenderer $channelRenderer,
        private MessageRenderer $messageRenderer,
        private InfoRenderer $infoRenderer,
        private array $servers,
        private string $schemaVersion,
    ) {
    }

    public function generate(): array
    {
        $classes = $this->classFinder->find();

        $channels = [];
        $messages = [];

        foreach ($classes as $class) {
            $document = $this->documentationStrategy->document($class);
            $document = $document->toArray();
            $channel = $this->channelRenderer->render($document);
            $message = $this->messageRenderer->render($document);

            $channelKey = key($channel);
            $messageKey = key($message);

            $channels[$channelKey] = $channel[$channelKey];
            $messages[$messageKey] = $message[$messageKey];
        }

        return [
            'asyncapi' => $this->schemaVersion,
            'info' => $this->infoRenderer->render(),
            'servers' => $this->servers,
            'channels' => $channels,
            'components' => [
                'messages' => $messages,
            ],
        ];
    }
}
