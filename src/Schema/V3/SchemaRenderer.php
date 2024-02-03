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
        private OperationRenderer $operationRenderer,
        private ChannelRenderer $channelRenderer,
        private array $servers,
        private string $schemaVersion,
    ) {
    }

    public function generate(): array
    {
        $classes = $this->classFinder->find();

        $channels = [];
        $messages = [];
        $operations = [];

        foreach ($classes as $class) {
            $document = $this->documentationEditor->document($class);
            $document = $document->toArray();

            $channel = $this->channelRenderer->render($document);
            $message = $this->messageRenderer->render($document);
            $operation = $this->operationRenderer->render($document);

            $channelKey = key($channel);
            $messageKey = key($message);
            $operationKey = key($operation);

            $channels[$channelKey] = $channel[$channelKey];
            $messages[$messageKey] = $message[$messageKey];
            $operations[$operationKey] = $operation[$operationKey];
        }

        $schema = [
            'asyncapi' => $this->schemaVersion,
            'info' => $this->infoRenderer->render(),
            'channels' => $channels,
            'operations' => $operations,
            'components' => [
                'messages' => $messages,
            ],
        ];

        if ($this->servers) {
            $schema['servers'] = $this->servers;
        }

        return $schema;
    }
}
