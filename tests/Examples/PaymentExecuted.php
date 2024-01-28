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
    public function __construct(
        public float $amount,
        public string $createdAt,
    ) {
    }
}
