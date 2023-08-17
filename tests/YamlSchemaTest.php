<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests;

use Ferror\AsyncapiDocBundle\YamlSchema;
use PHPUnit\Framework\TestCase;

class YamlSchemaTest extends TestCase
{
    public function test(): void
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

        $schema = new YamlSchema();

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

        $this->assertEquals($expectedSpecification, $specification);
    }
}