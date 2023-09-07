<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Integration;

use Ferror\AsyncapiDocBundle\Tests\UserSignedUp;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class DumpSpecificationConsoleTest extends KernelTestCase
{
    public function testExecuteClass(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('ferror:asyncapi:dump');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'class' => UserSignedUp::class,
        ]);

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


YAML;

        $this->assertEquals($expectedDisplay, $display);
    }

    public function testExecute(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('ferror:asyncapi:dump');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();

        $display = $commandTester->getDisplay();

        $expectedDisplay = <<<YAML
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


YAML;

        $this->assertEquals($expectedDisplay, $display);

        $content = file_put_contents(dirname(__DIR__) . '/../var/asyncapi.yaml', $display);

        if (false === $content) {
            throw new RuntimeException('Schema file was not save');
        }
    }
}
