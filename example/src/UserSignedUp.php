<?php

declare(strict_types=1);

namespace App;

use Ferror\AsyncapiDocBundle\Attribute\Message;

#[Message(name: 'UserSignedUp', channel: 'user_signed_up')]
final readonly class UserSignedUp
{
    public function __construct(
        public string $name,
        public string $email,
        public int $age,
        public bool $isCitizen,
    ) {
    }
}
