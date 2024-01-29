<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Examples;

use Ferror\AsyncapiDocBundle\Attribute\Message;

/**
 * This class represents an example of documenting by ReflectionStrategy
 */
#[Message(name: 'PaymentExecuted', channel: 'payment_executed')]
final readonly class PaymentExecuted
{
    public function __construct(
        public float $amount,
        public string $createdAt,
    ) {
    }
}
