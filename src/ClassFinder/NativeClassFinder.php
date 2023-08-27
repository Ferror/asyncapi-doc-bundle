<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\ClassFinder;

use Ferror\AsyncapiDocBundle\Attribute\Message;
use ReflectionClass;

class NativeClassFinder implements ClassFinderInterface
{
    /**
     * @return class-string[]
     */
    public function find(): array
    {
        $allClasses = get_declared_classes();

        return array_values(
            array_filter(
                $allClasses,
                static fn (string $class) => (new ReflectionClass($class))->getAttributes(Message::class)
            )
        );
    }
}
