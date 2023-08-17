<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests;

use Ferror\AsyncapiDocBundle\Attribute\Message;
use Ferror\AsyncapiDocBundle\Attribute\Property;
use Ferror\AsyncapiDocBundle\PropertyType;

#[Message(name: 'PaymentExecuted', channel: 'payment_executed')]
readonly class PaymentExecuted
{
    #[Property(name: 'amount', type: PropertyType::INTEGER, description: 'Payment amount', format: 'number', example: '1000')]
    public string $amount;
    #[Property(name: 'createdAt', type: PropertyType::DATETIME, description: 'Creation date', format: 'datetime', example: '2023-11-23 13:41:21')]
    public string $createdAt;
}