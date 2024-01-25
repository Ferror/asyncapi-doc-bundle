<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit\Symfony\Controller;

use Ferror\AsyncapiDocBundle\ClassFinder\ManualClassFinder;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\AttributeDocumentationStrategy;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\PropertyExtractor;
use Ferror\AsyncapiDocBundle\Generator\JsonGenerator;
use Ferror\AsyncapiDocBundle\Schema\V2\ChannelRenderer;
use Ferror\AsyncapiDocBundle\Schema\V2\InfoRenderer;
use Ferror\AsyncapiDocBundle\Schema\V2\MessageRenderer;
use Ferror\AsyncapiDocBundle\Schema\V2\SchemaRenderer;
use Ferror\AsyncapiDocBundle\Symfony\Controller\JsonSpecificationController;
use Ferror\AsyncapiDocBundle\Tests\Examples\PaymentExecuted;
use Ferror\AsyncapiDocBundle\Tests\Examples\ProductCreated;
use Ferror\AsyncapiDocBundle\Tests\Examples\UserSignedUp;
use PHPUnit\Framework\TestCase;

class JsonSpecificationControllerTest extends TestCase
{
    public function test(): void
    {
        $controller = new JsonSpecificationController(
            new JsonGenerator(
                new SchemaRenderer(
                    new ManualClassFinder([
                        UserSignedUp::class,
                        PaymentExecuted::class,
                        ProductCreated::class,
                    ]),
                    new AttributeDocumentationStrategy(new PropertyExtractor()),
                    new ChannelRenderer(),
                    new MessageRenderer(),
                    new InfoRenderer('Service Example API', 'This service is in charge of processing user signups', '1.2.3'),
                    [],
                    '2.6.0',
                )
            )
        );

        $expected = <<<JSON
{
  "asyncapi": "2.6.0",
  "info": {
    "title": "Service Example API",
    "version": "1.2.3",
    "description": "This service is in charge of processing user signups"
  },
  "servers": [],
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
              "type": "number",
              "description": "Payment amount",
              "format": "float",
              "example": "1000"
            },
            "createdAt": {
              "type": "string",
              "description": "Creation date",
              "format": "date-time",
              "example": "2023-11-23 13:41:21"
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
              "type": "integer",
              "description": ""
            },
            "amount": {
              "type": "number",
              "description": ""
            },
            "currency": {
              "type": "string",
              "description": ""
            },
            "isPaid": {
              "type": "boolean",
              "description": ""
            },
            "createdAt": {
              "type": "string",
              "description": "",
              "format": "date-time"
            },
            "week": {
              "type": "integer",
              "description": ""
            },
            "payment": {
              "type": "string",
              "description": ""
            },
            "products": {
              "type": "string",
              "description": ""
            },
            "tags": {
              "type": "string",
              "description": ""
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

        $this->assertJsonStringEqualsJsonString($expected, $controller()->getContent());
    }
}
