<?php

declare(strict_types=1);

namespace Ferror\AsyncapiDocBundle\Tests\Examples;

use DateTime;
use Ferror\AsyncapiDocBundle\Attribute\Message;
use Ferror\AsyncapiDocBundle\Attribute\Property;
use Ferror\AsyncapiDocBundle\Attribute\PropertyArray;
use Ferror\AsyncapiDocBundle\Attribute\PropertyArrayObject;
use Ferror\AsyncapiDocBundle\Attribute\PropertyEnum;
use Ferror\AsyncapiDocBundle\Attribute\PropertyObject;
use Ferror\AsyncapiDocBundle\Schema\Format;
use Ferror\AsyncapiDocBundle\Schema\PropertyType;

#[Message(name: 'ProductCreated', channel: 'product.created')]
final readonly class ProductCreated
{
    /**
     * @param Product[] $products
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
        #[PropertyEnum(name: 'week', enum: Week::class)]
        public Week $week,
        #[PropertyObject(name: 'payment', class: Payment::class)]
        public Payment $payment,
        #[PropertyArrayObject(name: 'products', class: Product::class)]
        public array $products,
        #[PropertyArray(name: 'tags', itemsType: 'string')]
        public array $tags,
    ) {
    }
}
