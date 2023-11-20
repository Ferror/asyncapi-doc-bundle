<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Examples;

use Ferror\AsyncapiDocBundle\Attribute\Message;
use Ferror\AsyncapiDocBundle\Attribute\Property;
use Ferror\AsyncapiDocBundle\Schema\Format;
use Ferror\AsyncapiDocBundle\Schema\PropertyType;

#[Message(name: 'PaymentExecuted', channel: 'payment_executed')]
final readonly class PaymentExecuted
{
    #[Property(name: 'amount', type: PropertyType::FLOAT, description: 'Payment amount', format: Format::FLOAT, example: '1000')]
    public float $amount;
    #[Property(name: 'createdAt', type: PropertyType::STRING, description: 'Creation date', format: Format::DATETIME, example: '2023-11-23 13:41:21')]
    public string $createdAt;
}
