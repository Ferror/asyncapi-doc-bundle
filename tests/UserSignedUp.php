<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests;

use Ferror\AsyncapiDocBundle\Attribute\Message;
use Ferror\AsyncapiDocBundle\Attribute\Property;
use Ferror\AsyncapiDocBundle\Format;
use Ferror\AsyncapiDocBundle\PropertyType;

#[Message(name: 'UserSignedUp', channel: 'user_signed_up')]
readonly class UserSignedUp
{
    #[Property(name: 'name', type: PropertyType::STRING, description: 'Name of the user', format: Format::STRING, example: 'John')]
    public string $name;
    #[Property(name: 'email', type: PropertyType::STRING, description: 'Email of the user', format: Format::EMAIL, example: 'john@example')]
    public string $email;
    #[Property(name: 'age', type: PropertyType::INTEGER, description: 'Age of the user', format: Format::INTEGER, example: '18')]
    public int $age;
    #[Property(name: 'isCitizen', type: PropertyType::BOOLEAN, description: 'Is user a citizen', format: Format::BOOLEAN, example: 'true')]
    public bool $isCitizen;
}