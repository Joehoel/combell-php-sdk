<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\Concerns\MapsToDto;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;

/**
 * Test request that uses MapsToDto with dtoRaw = true
 */
class RawBodyRequest extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected bool $dtoRaw = true;

    public function resolveEndpoint(): string
    {
        return '/raw';
    }
}

/**
 * Test request with no DTO class configured
 */
class NoDtoClassRequest extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/no-dto';
    }
}

/**
 * Simple DTO with fromResponse method
 */
class SimpleDto
{
    public function __construct(
        public ?string $name = null,
        public ?int $value = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            value: $data['value'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}

/**
 * DTO without fromResponse (uses reflection fallback)
 */
class ReflectionDto
{
    public function __construct(
        public ?string $name = null,
        public ?int $age = null,
    ) {}
}

/**
 * DTO with no constructor
 */
class NoConstructorDto
{
    public string $name = '';
}

/**
 * Test request with single DTO mapping
 */
class SingleDtoRequest extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = SimpleDto::class;

    public function resolveEndpoint(): string
    {
        return '/single';
    }
}

/**
 * Test request with list DTO mapping
 */
class ListDtoRequest extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = SimpleDto::class;

    protected bool $dtoIsList = true;

    public function resolveEndpoint(): string
    {
        return '/list';
    }
}

/**
 * Test request with list DTO mapping using collection key
 */
class CollectionKeyDtoRequest extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = SimpleDto::class;

    protected bool $dtoIsList = true;

    protected ?string $dtoCollectionKey = 'items';

    public function resolveEndpoint(): string
    {
        return '/collection';
    }
}

/**
 * Test request using reflection-based DTO instantiation
 */
class ReflectionDtoRequest extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = ReflectionDto::class;

    public function resolveEndpoint(): string
    {
        return '/reflection';
    }
}

/**
 * Test request with no-constructor DTO
 */
class NoConstructorDtoRequest extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = NoConstructorDto::class;

    public function resolveEndpoint(): string
    {
        return '/no-constructor';
    }
}

/**
 * Test request for list without collect method
 */
class ReflectionListDtoRequest extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected ?string $dtoClass = ReflectionDto::class;

    protected bool $dtoIsList = true;

    public function resolveEndpoint(): string
    {
        return '/reflection-list';
    }
}

// ============================================================================
// TESTS
// ============================================================================

it('returns raw body when dtoRaw is true', function () {
    $rawContent = 'This is raw content, not JSON';

    $mock = new MockClient([
        RawBodyRequest::class => MockResponse::make($rawContent, 200),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $response = $sdk->send(new RawBodyRequest);

    expect($response->dto())->toBe($rawContent);
});

it('returns null for 204 No Content response', function () {
    $mock = new MockClient([
        NoDtoClassRequest::class => MockResponse::make('', 204),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $response = $sdk->send(new NoDtoClassRequest);

    expect($response->dto())->toBeNull();
});

it('returns null for empty body', function () {
    $mock = new MockClient([
        NoDtoClassRequest::class => MockResponse::make('', 200),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $response = $sdk->send(new NoDtoClassRequest);

    expect($response->dto())->toBeNull();
});

it('returns JSON array when no dtoClass is configured', function () {
    $data = ['key' => 'value', 'number' => 42];

    $mock = new MockClient([
        NoDtoClassRequest::class => MockResponse::make(json_encode($data), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $response = $sdk->send(new NoDtoClassRequest);

    expect($response->dto())->toBe($data);
});

it('returns raw body when JSON parsing fails and no dtoClass', function () {
    $invalidJson = 'not valid json {{{';

    $mock = new MockClient([
        NoDtoClassRequest::class => MockResponse::make($invalidJson, 200),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $response = $sdk->send(new NoDtoClassRequest);

    expect($response->dto())->toBe($invalidJson);
});

it('instantiates single DTO via fromResponse method', function () {
    $data = ['name' => 'Test', 'value' => 123];

    $mock = new MockClient([
        SingleDtoRequest::class => MockResponse::make(json_encode($data), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $response = $sdk->send(new SingleDtoRequest);

    $dto = $response->dto();

    expect($dto)->toBeInstanceOf(SimpleDto::class);
    expect($dto->name)->toBe('Test');
    expect($dto->value)->toBe(123);
});

it('instantiates list of DTOs via collect method', function () {
    $data = [
        ['name' => 'First', 'value' => 1],
        ['name' => 'Second', 'value' => 2],
        ['name' => 'Third', 'value' => 3],
    ];

    $mock = new MockClient([
        ListDtoRequest::class => MockResponse::make(json_encode($data), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $response = $sdk->send(new ListDtoRequest);

    $dtos = $response->dto();

    expect($dtos)->toBeArray();
    expect($dtos)->toHaveCount(3);
    expect($dtos[0])->toBeInstanceOf(SimpleDto::class);
    expect($dtos[0]->name)->toBe('First');
    expect($dtos[1]->name)->toBe('Second');
    expect($dtos[2]->name)->toBe('Third');
});

it('extracts items from collection key for list DTOs', function () {
    $data = [
        'total' => 2,
        'items' => [
            ['name' => 'Item1', 'value' => 10],
            ['name' => 'Item2', 'value' => 20],
        ],
    ];

    $mock = new MockClient([
        CollectionKeyDtoRequest::class => MockResponse::make(json_encode($data), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $response = $sdk->send(new CollectionKeyDtoRequest);

    $dtos = $response->dto();

    expect($dtos)->toBeArray();
    expect($dtos)->toHaveCount(2);
    expect($dtos[0]->name)->toBe('Item1');
    expect($dtos[1]->name)->toBe('Item2');
});

it('returns empty array when collection key is missing', function () {
    $data = ['total' => 0];

    $mock = new MockClient([
        CollectionKeyDtoRequest::class => MockResponse::make(json_encode($data), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $response = $sdk->send(new CollectionKeyDtoRequest);

    expect($response->dto())->toBe([]);
});

it('returns empty array when list data is not an array', function () {
    $mock = new MockClient([
        ListDtoRequest::class => MockResponse::make('"just a string"', 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $response = $sdk->send(new ListDtoRequest);

    expect($response->dto())->toBe([]);
});

it('uses reflection fallback when DTO has no fromResponse method', function () {
    $data = ['name' => 'ReflectedName', 'age' => 30];

    $mock = new MockClient([
        ReflectionDtoRequest::class => MockResponse::make(json_encode($data), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $response = $sdk->send(new ReflectionDtoRequest);

    $dto = $response->dto();

    expect($dto)->toBeInstanceOf(ReflectionDto::class);
    expect($dto->name)->toBe('ReflectedName');
    expect($dto->age)->toBe(30);
});

it('instantiates DTO with no constructor', function () {
    $data = ['name' => 'ignored'];

    $mock = new MockClient([
        NoConstructorDtoRequest::class => MockResponse::make(json_encode($data), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $response = $sdk->send(new NoConstructorDtoRequest);

    $dto = $response->dto();

    expect($dto)->toBeInstanceOf(NoConstructorDto::class);
    // Properties are not mapped without constructor
    expect($dto->name)->toBe('');
});

it('uses reflection for list when DTO has no collect method', function () {
    $data = [
        ['name' => 'Person1', 'age' => 25],
        ['name' => 'Person2', 'age' => 35],
    ];

    $mock = new MockClient([
        ReflectionListDtoRequest::class => MockResponse::make(json_encode($data), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $response = $sdk->send(new ReflectionListDtoRequest);

    $dtos = $response->dto();

    expect($dtos)->toBeArray();
    expect($dtos)->toHaveCount(2);
    expect($dtos[0])->toBeInstanceOf(ReflectionDto::class);
    expect($dtos[0]->name)->toBe('Person1');
    expect($dtos[1]->age)->toBe(35);
});

it('handles partial data in reflection-based instantiation', function () {
    // Only provide 'name', missing 'age'
    $data = ['name' => 'OnlyName'];

    $mock = new MockClient([
        ReflectionDtoRequest::class => MockResponse::make(json_encode($data), 200, [
            'Content-Type' => 'application/json',
        ]),
    ]);

    $sdk = Combell::fake($mock, 'key', 'secret');
    $response = $sdk->send(new ReflectionDtoRequest);

    $dto = $response->dto();

    expect($dto)->toBeInstanceOf(ReflectionDto::class);
    expect($dto->name)->toBe('OnlyName');
    expect($dto->age)->toBeNull();
});
