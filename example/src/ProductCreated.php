<?php

declare(strict_types=1);

namespace App;

use DateTime;
use Ferror\AsyncapiDocBundle\Attribute\Message;
use Ferror\AsyncapiDocBundle\Attribute\Property;
use Ferror\AsyncapiDocBundle\Attribute\PropertyArray;
use Ferror\AsyncapiDocBundle\Schema\Format;
use Ferror\AsyncapiDocBundle\Schema\PropertyType;

#[Message(name: 'ProductCreated', channel: 'product.created')]
final readonly class ProductCreated
{
    /**
     * @param string[] $tags
     */
    public function __construct(
        #[Property(name: 'id', type: PropertyType::INTEGER)]
        public int $id,
        #[Property(name: 'amount', type: PropertyType::FLOAT)]
        public float $amount,
        #[Property(name: 'currency', type: PropertyType::STRING)]
        public string $currency,
        #[Property(name: 'isPaid', type: PropertyType::BOOLEAN)]
        public bool $isPaid,
        #[Property(name: 'createdAt', type: PropertyType::STRING, format: Format::DATETIME)]
        public DateTime $createdAt,
        #[PropertyArray(name: 'tags', itemsType: PropertyType::STRING)]
        public array $tags,
    ) {
    }
}
