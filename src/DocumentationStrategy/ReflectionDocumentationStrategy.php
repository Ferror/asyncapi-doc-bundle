<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\DocumentationStrategy;

use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;

final readonly class ReflectionDocumentationStrategy implements DocumentationStrategyInterface
{
    /**
     * @param class-string $class
     *
     * @throws ReflectionException
     */
    public function document(string $class): array
    {
        $reflection = new ReflectionClass($class);
        $properties = $reflection->getProperties();

        $message['name'] = $reflection->getShortName();

        foreach ($properties as $property) {
            /** @var ReflectionNamedType|null $type */
            $type = $property->getType();
            $name = $property->getName();

            if ($type && !$type->allowsNull()) {
                $message['required'][] = $name;
            }

            $message['properties'][] = [
                'name' => $name,
                'type' => $type?->getName(),
            ];
        }

        return $message;
    }
}
