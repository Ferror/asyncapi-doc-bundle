<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle;

interface SchemaInterface
{
    public function supports(string $version): bool;
    public function renderMessage(array $document): array;
    public function renderChannel(array $document): array;
}
