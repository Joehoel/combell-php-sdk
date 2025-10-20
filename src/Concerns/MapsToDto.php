<?php

namespace Joehoel\Combell\Concerns;

use Saloon\Http\Response;

/**
 * Provides a default implementation for Saloon's createDtoFromResponse
 * allowing requests to declare a DTO class and whether the response
 * is a list (optionally under a specific JSON key like 'items').
 *
 * This trait is non-invasive: it does not define properties that could
 * conflict with your request classes. If you prefer using properties on
 * your requests, simply define any of the following on the request:
 * - protected ?string $dtoClass
 * - protected bool $dtoIsList
 * - protected ?string $dtoCollectionKey
 * - protected bool $dtoRaw
 */
trait MapsToDto
{
    public function createDtoFromResponse(Response $response): mixed
    {
        if ($this->getDtoRaw() === true) {
            return $response->body();
        }

        $status = $response->status();
        $body = $response->body();

        if ($status === 204 || $body === '' || $body === null) {
            return null;
        }

        $class = $this->getDtoClass();

        if ($class === null) {
            try {
                return $response->json();
            } catch (\Throwable) {
                return $body;
            }
        }

        try {
            $data = $response->json();
        } catch (\Throwable) {
            $data = $body;
        }

        if ($this->getDtoIsList() === true) {
            $items = $data;
            $key = $this->getDtoCollectionKey();
            if (is_array($data) && $key !== null) {
                $items = $data[$key] ?? [];
            }

            if (! is_array($items)) {
                return [];
            }

            // If the DTO provides a static collect method, delegate to it
            if (is_callable([$class, 'collect'])) {
                return $class::collect(array_map(fn ($i) => (array) $i, $items));
            }

            return array_map(function ($item) use ($class) {
                $arr = is_object($item) ? (array) $item : (array) $item;

                return $this->instantiateDto($class, $arr);
            }, $items);
        }

        return $this->instantiateDto(
            $class,
            is_array($data) ? $data : (array) $data,
        );
    }

    protected function getDtoClass(): ?string
    {
        return \property_exists($this, 'dtoClass') ? $this->dtoClass : null;
    }

    protected function getDtoIsList(): bool
    {
        return \property_exists($this, 'dtoIsList')
            ? (bool) $this->dtoIsList
            : false;
    }

    protected function getDtoCollectionKey(): ?string
    {
        return \property_exists($this, 'dtoCollectionKey')
            ? $this->dtoCollectionKey
            : null;
    }

    protected function getDtoRaw(): bool
    {
        return \property_exists($this, 'dtoRaw') ? (bool) $this->dtoRaw : false;
    }

    /**
     * Instantiate the DTO class, preferring a static fromResponse constructor
     * if available (matching Oh Dear's DTO pattern). Falls back to mapping
     * array keys to promoted properties by name when no factory exists.
     */
    private function instantiateDto(string $class, array $input): object
    {
        // Prefer a static fromResponse method if present
        if (is_callable([$class, 'fromResponse'])) {
            return $class::fromResponse($input);
        }

        // Otherwise, best-effort map array keys to promoted properties
        $ref = new \ReflectionClass($class);
        $ctor = $ref->getConstructor();
        $args = [];

        if ($ctor) {
            foreach ($ctor->getParameters() as $param) {
                $name = $param->getName();
                if (array_key_exists($name, $input)) {
                    $args[$name] = $input[$name];
                }
            }

            return $ref->newInstanceArgs($args);
        }

        // If there's no constructor, just instantiate with no args
        return new $class;
    }
}
