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
        required: true
      email:
        type: string
        description: 'Email of the user'
        format: email
        example: john@example.com
        required: true
      age:
        type: integer
        description: 'Age of the user'
        format: int32
        example: '18'
        required: true
      isCitizen:
        type: boolean
        description: 'Is user a citizen'
        format: boolean
        example: 'true'
        required: true


YAML;

        $this->assertEquals($expectedDisplay, $display);
    }

    public function testExecuteYaml(): void
    {
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
servers:
  production:
    url: broker.mycompany.com
    protocol: amqp
    description: 'This is production broker.'
  staging:
    url: broker.mycompany.com
    protocol: amqp
    description: 'This is staging broker.'
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
            required: true
          email:
            type: string
            description: 'Email of the user'
            format: email
            example: john@example.com
            required: true
          age:
            type: integer
            description: 'Age of the user'
            format: int32
            example: '18'
            required: true
          isCitizen:
            type: boolean
            description: 'Is user a citizen'
            format: boolean
            example: 'true'
            required: true
    PaymentExecuted:
      payload:
        type: object
        properties:
          amount:
            type: number
            description: 'Payment amount'
            format: float
            example: '1000'
            required: true
          createdAt:
            type: string
            description: 'Creation date'
            format: date-time
            example: '2023-11-23 13:41:21'
            required: true
    ProductCreated:
      payload:
        type: object
        properties:
          id:
            type: integer
            description: ''
            required: true
          amount:
            type: number
            description: ''
            required: true
          currency:
            type: string
            description: ''
            required: true
          isPaid:
            type: boolean
            description: ''
            required: true
          createdAt:
            type: string
            description: ''
            format: date-time
            required: true
          week:
            type: integer
            description: ''
            required: true
          payment:
            type: string
            description: ''
            required: true
          products:
            type: string
            description: ''
            required: true
          tags:
            type: string
            description: ''
            required: true


YAML;

        $this->assertEquals($expectedDisplay, $display);

        $content = file_put_contents(dirname(__DIR__) . '/../var/asyncapi.yaml', $display);

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
              "example": "John",
              "required": true
            },
            "email": {
              "type": "string",
              "description": "Email of the user",
              "format": "email",
              "example": "john@example.com",
              "required": true
            },
            "age": {
              "type": "integer",
              "description": "Age of the user",
              "format": "int32",
              "example": "18",
              "required": true
            },
            "isCitizen": {
              "type": "boolean",
              "description": "Is user a citizen",
              "format": "boolean",
              "example": "true",
              "required": true
            }
          }
        }
      },
      "PaymentExecuted": {
        "payload": {
          "type": "object",
          "properties": {
            "amount": {
              "type": "number",
              "description": "Payment amount",
              "format": "float",
              "example": "1000",
              "required": true
            },
            "createdAt": {
              "type": "string",
              "description": "Creation date",
              "format": "date-time",
              "example": "2023-11-23 13:41:21",
              "required": true
            }
          }
        }
      },
      "ProductCreated": {
        "payload": {
          "type": "object",
          "properties": {
            "id": {
              "type": "integer",
              "description": "",
              "required": true
            },
            "amount": {
              "type": "number",
              "description": "",
              "required": true
            },
            "currency": {
              "type": "string",
              "description": "",
              "required": true
            },
            "isPaid": {
              "type": "boolean",
              "description": "",
              "required": true
            },
            "createdAt": {
              "type": "string",
              "description": "",
              "format": "date-time",
              "required": true
            },
            "week": {
              "type": "integer",
              "description": "",
              "required": true
            },
            "payment": {
              "type": "string",
              "description": "",
              "required": true
            },
            "products": {
              "type": "string",
              "description": "",
              "required": true
            },
            "tags": {
              "type": "string",
              "description": "",
              "required": true
            }
          }
        }
      }
    }
  }
}

JSON;

        $this->assertJsonStringEqualsJsonString($expectedDisplay, $display);

        $content = file_put_contents(dirname(__DIR__) . '/../var/asyncapi.json', $display);

        if (false === $content) {
            throw new RuntimeException('Schema file was not save');
        }
    }
}
