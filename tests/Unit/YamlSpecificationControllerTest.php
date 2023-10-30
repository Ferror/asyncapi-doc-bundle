<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Unit;

use Ferror\AsyncapiDocBundle\ClassFinder\NativeClassFinder;
use Ferror\AsyncapiDocBundle\DocumentationStrategy\AttributeDocumentationStrategy;
use Ferror\AsyncapiDocBundle\PropertyExtractor;
use Ferror\AsyncapiDocBundle\Schema;
use Ferror\AsyncapiDocBundle\SchemaGenerator;
use Ferror\AsyncapiDocBundle\Symfony\Controller\YamlSpecificationController;
use Ferror\AsyncapiDocBundle\YamlGenerator;
use PHPUnit\Framework\TestCase;

class YamlSpecificationControllerTest extends TestCase
{
    public function test(): void
    {
        $controller = new YamlSpecificationController(
            new YamlGenerator(
                new SchemaGenerator(
                    new NativeClassFinder(),
                    new AttributeDocumentationStrategy(new PropertyExtractor()),
                    new Schema(),
                )
            )
        );

        $expected = <<<YAML
asyncapi: 2.6.0
info:
  title: 'Account Service'
  version: 1.0.0
  description: 'This service is in charge of processing user signups'
servers: {  }
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
    PaymentExecuted:
      payload:
        type: object
        properties:
          amount:
            type: number
            description: 'Payment amount'
            format: float
            example: '1000'
          createdAt:
            type: string
            description: 'Creation date'
            format: date-time
            example: '2023-11-23 13:41:21'
    ProductCreated:
      payload:
        type: object
        properties:
          id:
            type: integer
            description: ''
          amount:
            type: number
            description: ''
          currency:
            type: string
            description: ''
          isPaid:
            type: boolean
            description: ''
          createdAt:
            type: string
            description: ''
            format: date-time
          week:
            type: integer
            description: ''
          payment:
            type: string
            description: ''
          products:
            type: string
            description: ''
          tags:
            type: string
            description: ''

YAML;

        $this->assertEquals($expected, $controller()->getContent());
    }
}
