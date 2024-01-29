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

/**
 * This class represents an example of documenting by AttributeStrategy. The properties are provided via objects.
 */
#[Message(
    name: 'ProductUpdated',
    channel: 'product.updated',
    properties: [
        new Property(name: 'id', type: PropertyType::INTEGER),
        new Property(name: 'amount', type: PropertyType::FLOAT),
        new Property(name: 'currency', type: PropertyType::STRING),
        new Property(name: 'isPaid', type: PropertyType::BOOLEAN),
        new Property(name: 'createdAt', type: PropertyType::STRING, format: Format::DATETIME),
        new PropertyEnum(name: 'week', enum: Week::class),
        new PropertyObject(name: 'payment', class: Payment::class),
        new PropertyArrayObject(name: 'products', class: Product::class),
        new PropertyArray(name: 'tags', itemsType: PropertyType::STRING),
    ],
)]
final readonly class ProductUpdated
{
    /**
     * @param Product[] $products
     * @param string[] $tags
     */
    public function __construct(
        public int $id,
        public float $amount,
        public string $currency,
        public bool $isPaid,
        public DateTime $createdAt,
        public Week $week,
        public Payment $payment,
        public array $products,
        public array $tags,
    ) {
    }
}
