<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests;

use Ferror\AsyncapiDocBundle\Attribute\Message;
use Ferror\AsyncapiDocBundle\Attribute\Property;
use Ferror\AsyncapiDocBundle\PropertyType;

#[Message(name: 'UserSignedUp')]
readonly class UserSignedUp
{
    #[Property(name: 'name', type: PropertyType::STRING, description: 'Name of the user', format: 'string', example: 'John')]
    public string $name;
    #[Property(name: 'email', type: PropertyType::STRING, description: 'Email of the user', format: 'email', example: 'john@example')]
    public string $email;
    #[Property(name: 'age', type: PropertyType::STRING, description: 'Age of the user', format: 'int', example: '18')]
    public int $age;
    #[Property(name: 'isCitizen', type: PropertyType::BOOL, description: 'Is user a citizen', format: 'boolean', example: 'true')]
    public bool $isCitizen;
}