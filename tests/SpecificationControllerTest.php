<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests;

use Ferror\AsyncapiDocBundle\Symfony\Controller\SpecificationController;
use PHPUnit\Framework\TestCase;

class SpecificationControllerTest extends TestCase
{
    public function test(): void
    {
        $controller = new SpecificationController();

        $expected = <<<YAML
asyncapi: 2.6.0
info:
  title: 'Account Service'
  version: 1.0.0
  description: 'This service is in charge of processing user signups'
channels:
  user_signed_up:
    subscribe:
      message:
        \$ref: '#/components/messages/UserSignedUp'
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
            example: john@example
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

        $this->assertEquals($expected, $controller()->getContent());
    }
}