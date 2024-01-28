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

        $actual = $documentationEditor->document(PaymentExecuted::class);

        $expected = [
            'name' => "PaymentExecuted",
            'channel' => "payment_executed",
            "channelType" => "subscribe",
            'properties' => [
                [
                    "name" => "amount",
                    "required" => true,
                    "type" => "float",
                ],
                [
                    "name" => "createdAt",
                    "description" => "Creation date",
                    "required" => true,
                    "type" => "string",
                    "format" => "date-time",
                    "example" => "2023-11-23 13:41:21",
                ],
            ],
        ];

        $this->assertEquals($expected, $actual);
    }
}
