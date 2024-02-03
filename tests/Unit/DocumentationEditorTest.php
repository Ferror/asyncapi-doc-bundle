<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit;

use Ferror\AsyncapiDocBundle\DocumentationEditor;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\AttributeDocumentationStrategy;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\ReflectionDocumentationStrategy;
use Ferror\AsyncapiDocBundle\Tests\Examples\PaymentExecuted;
use Ferror\AsyncapiDocBundle\Tests\Examples\UserSignedUp;
use PHPUnit\Framework\TestCase;

final class DocumentationEditorTest extends TestCase
{
    public function testDocument(): void
    {
        $documentationEditor = new DocumentationEditor([
            new ReflectionDocumentationStrategy(),
            new AttributeDocumentationStrategy(),
        ]);

        $actual = $documentationEditor->document(PaymentExecuted::class)->toArray();

        $expected = [
            'name' => 'PaymentExecuted',
            'properties' => [
                [
                    'name' => 'amount',
                    'required' => true,
                    'type' => 'number',
                    'description' => '',
                    'format' => null,
                    'example' => null,
                ],
                [
                    'name' => 'createdAt',
                    'description' => '',
                    'required' => true,
                    'type' => 'string',
                    'format' => null,
                    'example' => null,
                ],
            ],
            'channels' => [],
        ];

        $this->assertEquals($expected, $actual);
    }
}
