<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit;

use Ferror\AsyncapiDocBundle\Schema;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

class SchemaTest extends TestCase
{
    public function testReflection(): void
    {
        $document = [
            'name' => 'UserSignedUp',
            'properties' => [
                [
                    'name' => 'name',
                    'type' => 'string',
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                ],
                [
                    'name' => 'age',
                    'type' => 'int',
                ],
                [
                    'name' => 'isCitizen',
                    'type' => 'bool',
                ],
            ],
        ];

        $schema = new Schema();

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
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'description' => 'Email of the user',
                    'format' => 'email',
                    'example' => 'john@example.com',
                ],
                [
                    'name' => 'age',
                    'type' => 'integer',
                    'description' => 'Age of the user',
                    'format' => 'int',
                    'example' => '18',
                ],
                [
                    'name' => 'isCitizen',
                    'type' => 'boolean',
                    'description' => 'Is user a citizen',
                    'format' => 'boolean',
                    'example' => 'true',
                ],
            ],
        ];

        $schema = new Schema();

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

YAML;

        $this->assertEquals($expectedSpecification, Yaml::dump($specification, 10, 2));
    }
}
