<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Schema\V3;

use Ferror\AsyncapiDocBundle\ClassFinder\ClassFinderInterface;
use Ferror\AsyncapiDocBundle\DocumentationEditor;
use Ferror\AsyncapiDocBundle\SchemaRendererInterface;

final readonly class SchemaRenderer implements SchemaRendererInterface
{
    public function __construct(
        private ClassFinderInterface $classFinder,
        private DocumentationEditor $documentationEditor,
        private InfoRenderer $infoRenderer,
        private MessageRenderer $messageRenderer,
        private ChannelRenderer $channelRenderer,
        private ServerRenderer $serverRenderer,
        private string $schemaVersion,
    ) {
    }

    public function generate(): array
    {
        $classes = $this->classFinder->find();

        $channels = [];
        $messages = [];

        foreach ($classes as $class) {
            $document = $this->documentationEditor->document($class);
            $document = $document->toArray();

            $channel = $this->channelRenderer->render($document);
            $message = $this->messageRenderer->render($document);

            $channelKey = key($channel);
            $messageKey = key($message);

            $channels[$channelKey] = $channel[$channelKey];
            $messages[$messageKey] = $message[$messageKey];
        }

        $schema = [
            'asyncapi' => $this->schemaVersion,
            'info' => $this->infoRenderer->render(),
            'channels' => $channels,
            'components' => [
                'messages' => $messages,
            ],
        ];

        $servers = $this->serverRenderer->render();

        if ($servers) {
            $schema['servers'] = $servers;
        }

        return $schema;
    }
}
