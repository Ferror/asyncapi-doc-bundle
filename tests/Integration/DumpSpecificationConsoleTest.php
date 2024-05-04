<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Integration;

use Ferror\AsyncapiDocBundle\Tests\Examples\UserSignedUp;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class DumpSpecificationConsoleTest extends KernelTestCase
{
    public function testExecuteClass(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('ferror:asyncapi:dump');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['class' => UserSignedUp::class]);

        $commandTester->assertCommandIsSuccessful();

        $display = $commandTester->getDisplay();

        $expectedDisplay = <<<YAML
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
        format: int32
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

        $this->assertEquals($expectedDisplay, $display);
    }

    public function testExecuteYamlV2(): void
    {
        if ($this->isV3()) {
            $this->markTestSkipped('Skipping schema V2 test on V3 variable');
        }

        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('ferror:asyncapi:dump');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['format' => 'yaml']);

        $commandTester->assertCommandIsSuccessful();

        $display = $commandTester->getDisplay();

        $expectedDisplay = <<<YAML
asyncapi: 2.6.0
info:
  title: 'Service Example API'
  version: 1.2.3
  description: 'This service is in charge of processing user signups'
channels:
  user_signed_up:
    subscribe:
      message:
        \$ref: '#/components/messages/UserSignedUp'
  payment_executed:
    subscribe:
      message:
        \$ref: '#/components/messages/PaymentExecuted'
  product.created:
    subscribe:
      message:
        \$ref: '#/components/messages/ProductCreated'
components:
  messages:
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
            format: int32
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
    PaymentExecuted:
      payload:
        type: object
        properties:
          amount:
            type: number
          createdAt:
            type: string
        required:
          - amount
          - createdAt
    ProductCreated:
      payload:
        type: object
        properties:
          id:
            type: integer
          amount:
            type: number
          currency:
            type: string
          isPaid:
            type: boolean
          createdAt:
            type: string
            format: date-time
          week:
            type: integer
          payment:
            type: string
          products:
            type: string
          tags:
            type: string
        required:
          - id
          - amount
          - currency
          - isPaid
          - createdAt
          - week
          - payment
          - products
          - tags
servers:
  production:
    url: broker.mycompany.com
    protocol: amqp
    description: 'This is production broker.'
  staging:
    url: broker.mycompany.com
    protocol: amqp
    description: 'This is staging broker.'


YAML;

        if (false === $this->isV3()) {
            $this->assertEquals($expectedDisplay, $display);
        }

        mkdir(dirname(__DIR__) . '/../var/' . $this->getSchemaVersion());

        $content = file_put_contents(dirname(__DIR__) . '/../var/' . $this->getSchemaVersion() . '/asyncapi.yaml', $display);

        if (false === $content) {
            throw new RuntimeException('Schema file was not save');
        }
    }

    public function testExecuteYamlV3(): void
    {
        if (false === $this->isV3()) {
            $this->markTestSkipped('Skipping schema V3 test on V2 variable');
        }

        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('ferror:asyncapi:dump');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['format' => 'yaml']);

        $commandTester->assertCommandIsSuccessful();

        $display = $commandTester->getDisplay();

        $expectedDisplay = <<<YAML
asyncapi: 3.0.0
info:
  title: 'Service Example API'
  version: 1.2.3
  description: 'This service is in charge of processing user signups'
channels:
  user_signed_up:
    messages:
      UserSignedUp:
        \$ref: '#/components/messages/UserSignedUp'
  payment_executed:
    messages:
      PaymentExecuted:
        \$ref: '#/components/messages/PaymentExecuted'
  product.created:
    messages:
      ProductCreated:
        \$ref: '#/components/messages/ProductCreated'
components:
  messages:
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
            format: int32
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
    PaymentExecuted:
      payload:
        type: object
        properties:
          amount:
            type: number
          createdAt:
            type: string
        required:
          - amount
          - createdAt
    ProductCreated:
      payload:
        type: object
        properties:
          id:
            type: integer
          amount:
            type: number
          currency:
            type: string
          isPaid:
            type: boolean
          createdAt:
            type: string
            format: date-time
          week:
            type: integer
          payment:
            type: string
          products:
            type: string
          tags:
            type: string
        required:
          - id
          - amount
          - currency
          - isPaid
          - createdAt
          - week
          - payment
          - products
          - tags
servers:
  production:
    protocol: amqp
    description: 'This is production broker.'
    host: broker.mycompany.com
  staging:
    protocol: amqp
    description: 'This is staging broker.'
    host: broker.mycompany.com


YAML;

        $this->assertEquals($expectedDisplay, $display);

        mkdir(dirname(__DIR__) . '/../var/' . $this->getSchemaVersion());

        $content = file_put_contents(dirname(__DIR__) . '/../var/' . $this->getSchemaVersion() . '/asyncapi.yaml', $display);

        if (false === $content) {
            throw new RuntimeException('Schema file was not save');
        }
    }

    public function testExecuteJson(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('ferror:asyncapi:dump');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['format' => 'json']);

        $commandTester->assertCommandIsSuccessful();

        $display = $commandTester->getDisplay();

        $expectedDisplay = <<<JSON
{
  "asyncapi": "2.6.0",
  "info": {
    "title": "Service Example API",
    "version": "1.2.3",
    "description": "This service is in charge of processing user signups"
  },
  "servers": {
    "production": {
      "url": "broker.mycompany.com",
      "protocol": "amqp",
      "description": "This is production broker."
    },
    "staging": {
      "url": "broker.mycompany.com",
      "protocol": "amqp",
      "description": "This is staging broker."
    }
  },
  "channels": {
    "user_signed_up": {
      "subscribe": {
        "message": {
          "\$ref": "#/components/messages/UserSignedUp"
        }
      }
    },
    "payment_executed": {
      "subscribe": {
        "message": {
          "\$ref": "#/components/messages/PaymentExecuted"
        }
      }
    },
    "product.created": {
      "subscribe": {
        "message": {
          "\$ref": "#/components/messages/ProductCreated"
        }
      }
    }
  },
  "components": {
    "messages": {
      "UserSignedUp": {
        "payload": {
          "type": "object",
          "properties": {
            "name": {
              "type": "string",
              "description": "Name of the user",
              "format": "string",
              "example": "John"
            },
            "email": {
              "type": "string",
              "description": "Email of the user",
              "format": "email",
              "example": "john@example.com"
            },
            "age": {
              "type": "integer",
              "description": "Age of the user",
              "format": "int32",
              "example": "18"
            },
            "isCitizen": {
              "type": "boolean",
              "description": "Is user a citizen",
              "format": "boolean",
              "example": "true"
            }
          },
          "required": [
            "name",
            "email",
            "age",
            "isCitizen"
          ]
        }
      },
      "PaymentExecuted": {
        "payload": {
          "type": "object",
          "properties": {
            "amount": {
              "type": "number"
            },
            "createdAt": {
              "type": "string"
            }
          },
          "required": [
            "amount",
            "createdAt"
          ]
        }
      },
      "ProductCreated": {
        "payload": {
          "type": "object",
          "properties": {
            "id": {
              "type": "integer"
            },
            "amount": {
              "type": "number"
            },
            "currency": {
              "type": "string"
            },
            "isPaid": {
              "type": "boolean"
            },
            "createdAt": {
              "type": "string",
              "format": "date-time"
            },
            "week": {
              "type": "integer"
            },
            "payment": {
              "type": "string"
            },
            "products": {
              "type": "string"
            },
            "tags": {
              "type": "string"
            }
          },
          "required": [
            "id",
            "amount",
            "currency",
            "isPaid",
            "createdAt",
            "week",
            "payment",
            "products",
            "tags"
          ]
        }
      }
    }
  }
}

JSON;

        if (false === $this->isV3()) {
            $this->assertJsonStringEqualsJsonString($expectedDisplay, $display);
        }

        mkdir(dirname(__DIR__) . '/../var/' . $this->getSchemaVersion());

        $content = file_put_contents(dirname(__DIR__) . '/../var/' . $this->getSchemaVersion() . '/asyncapi.json', $display);

        if (false === $content) {
            throw new RuntimeException('Schema file was not save');
        }
    }

    private function getSchemaVersion(): string
    {
        return getenv('ASYNCAPI_VERSION');
    }

    private function isV3(): bool
    {
        $version = getenv('ASYNCAPI_VERSION');

        return $version === '3.0.0';
    }
}
