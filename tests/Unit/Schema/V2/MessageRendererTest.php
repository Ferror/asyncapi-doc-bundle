<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit\Schema\V2;

use Ferror\AsyncapiDocBundle\Schema\V2\MessageRenderer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

class MessageRendererTest extends TestCase
{
    public function testReflection(): void
    {
        $document = [
            'name' => 'UserSignedUp',
            'properties' => [
                [
                    'name' => 'name',
                    'type' => 'string',
                    'required' => true,
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'required' => true,
                ],
                [
                    'name' => 'age',
                    'type' => 'int',
                    'required' => true,
                ],
                [
                    'name' => 'isCitizen',
                    'type' => 'bool',
                    'required' => true,
                ],
            ],
        ];

        $schema = new MessageRenderer();

        $specification = $schema->render($document);

        $expectedSpecification = <<<YAML
UserSignedUp:
  payload:
    type: object
    properties:
      name:
        type: string
      email:
        type: string
      age:
        type: integer
      isCitizen:
        type: boolean
    required:
      - name
      - email
      - age
      - isCitizen

YAML;

        $this->assertEquals($expectedSpecification, Yaml::dump($specification, 10, 2));
    }

    public function testAttributes(): void
    {
        $document = [
            'name' => 'UserSignedUp',
            'properties' => [
                [
                    'name' => 'name',
                    'type' => 'string',
                    'description' => 'Name of the user',
                    'example' => 'John',
                    'format' => 'string',
                    'required' => true,
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'description' => 'Email of the user',
                    'format' => 'email',
                    'example' => 'john@example.com',
                    'required' => true,
                ],
                [
                    'name' => 'age',
                    'type' => 'integer',
                    'description' => 'Age of the user',
                    'format' => 'int',
                    'example' => '18',
                    'required' => true,
                ],
                [
                    'name' => 'isCitizen',
                    'type' => 'boolean',
                    'description' => 'Is user a citizen',
                    'format' => 'boolean',
                    'example' => 'true',
                    'required' => true,
                ],
            ],
        ];

        $schema = new MessageRenderer();

        $specification = $schema->render($document);

        $expectedSpecification = <<<YAML
UserSignedUp:
  payload:
    type: object
    properties:
      name:
        type: string
        description: 'Name of the user'
        format: string
        example: John
      email:
        type: string
        description: 'Email of the user'
        format: email
        example: john@example.com
      age:
        type: integer
        description: 'Age of the user'
        format: int
        example: '18'
      isCitizen:
        type: boolean
        description: 'Is user a citizen'
        format: boolean
        example: 'true'
    required:
      - name
      - email
      - age
      - isCitizen

YAML;

        $this->assertEquals($expectedSpecification, Yaml::dump($specification, 10, 2));
    }

    public function testDoesNotRenderEmptyData(): void
    {
        $document = [
            'name' => 'UserSignedUp',
            'properties' => [
                [
                    'name' => 'firstName',
                    'type' => 'string',
                    'description' => '',
                    'example' => '',
                    'format' => null,
                ],
                [
                    'name' => 'secondName',
                    'type' => 'string',
                    'description' => '',
                    'example' => '',
                    'format' => '',
                ],
            ],
        ];

        $schema = new MessageRenderer();

        $actual = $schema->render($document);

        $expected = [
            'UserSignedUp' => [
                'payload' => [
                    'type' => 'object',
                    'properties' => [
                        'firstName' => [
                            'type' => 'string',
                        ],
                        'secondName' => [
                            'type' => 'string',
                        ],
                    ],
                    'required' => [],
                ],
            ],
        ];

        $this->assertEquals($expected, $actual);
    }
}
