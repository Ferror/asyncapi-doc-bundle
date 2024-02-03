# Async API Symfony Bundle

The library was inspired by [nelmio/api-doc-bundle](https://github.com/nelmio/NelmioApiDocBundle); To create a code-first experience
for PHP and Symfony engineers. This piece of software enables you to document events and messages via PHP built-in Attributes.

Features
* Code-first async messages documentation
* Built-in ability to present code powered by [Async API React Component](https://github.com/asyncapi/asyncapi-react)
* Automated documentation powered by PHP Reflection

## Installation

```bash
composer require ferror/asyncapi-doc-bundle
```

```php
// config/bundles.php
return [
    Ferror\AsyncapiDocBundle\Symfony\Bundle::class => ['all' => true],
];
```
```yaml
# config/packages/asyncapi_doc_bundle.yaml
ferror_asyncapi_doc_bundle:
  asyncapi_version: '2.6.0' # Async API specification version (default: 2.6.0)
  title: 'Service Example API'
  version: '1.2.3' # Your API version
  events: # The event class namespace
    - Ferror\AsyncapiDocBundle\Tests\Examples\UserSignedUp
```
```yaml
# config/routes.yaml
ferror_asyncapi_doc_bundle_yaml:
    path: /asyncapi.yaml
    controller: ferror.asyncapi_doc_bundle.controller.yaml
    methods: GET

ferror_asyncapi_doc_bundle_json:
    path: /asyncapi.json
    controller: ferror.asyncapi_doc_bundle.controller.json
    methods: GET

ferror_asyncapi_doc_bundle_html:
    path: /asyncapi
    controller: ferror.asyncapi_doc_bundle.controller.ui
    methods: GET
```

## Minimal Usage

> Async API Symfony Bundle will use Reflection to determine the type and name of properties.
>
> Check out the other example if you want to define them manually.

```php
use Ferror\AsyncapiDocBundle\Attribute\Message;
use Ferror\AsyncapiDocBundle\Attribute\Channel;

#[Message(name: 'ProductCreated')]
#[Channel(name: 'product.created')] // optional
final readonly class ProductCreated
{
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
```

## Usage

```php
use Ferror\AsyncapiDocBundle\Attribute as AA;
use Ferror\AsyncapiDocBundle\Schema\Format;
use Ferror\AsyncapiDocBundle\Schema\PropertyType;

#[AA\Message(name: 'ProductCreated')]
#[AA\Channel(name: 'product.created')] // optional
final readonly class ProductCreated
{
    public function __construct(
        #[AA\Property(name: 'id', type: PropertyType::INTEGER)]
        public int $id,
        #[AA\Property(name: 'amount', type: PropertyType::FLOAT)]
        public float $amount,
        #[AA\Property(name: 'currency', type: PropertyType::STRING)]
        public string $currency,
        #[AA\Property(name: 'isPaid', type: PropertyType::BOOLEAN)]
        public bool $isPaid,
        #[AA\Property(name: 'createdAt', type: PropertyType::STRING, format: Format::DATETIME)]
        public DateTime $createdAt,
        #[AA\PropertyEnum(name: 'week', enum: Week::class)]
        public Week $week,
        #[AA\PropertyObject(name: 'payment', class: Payment::class)]
        public Payment $payment,
        #[AA\PropertyArrayObject(name: 'products', class: Product::class)]
        public array $products,
        #[AA\PropertyArray(name: 'tags', itemsType: 'string')]
        public array $tags,
    ) {
    }
}
```
