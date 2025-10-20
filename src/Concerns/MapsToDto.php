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
     * Instantiate the DTO class without relying on Spatie Data's static factory,
     * to keep this SDK framework-agnostic.
     */
    private function instantiateDto(string $class, array $input): object
    {
        // Build a map of property name => input key (respects MapName attribute when present)
        $ref = new \ReflectionClass($class);
        $args = [];

        foreach ($ref->getProperties() as $prop) {
            $propName = $prop->getName();
            $mapKey = $propName;

            foreach ($prop->getAttributes() as $attr) {
                if (
                    $attr->getName() ===
                    \Spatie\LaravelData\Attributes\MapName::class
                ) {
                    $inst = $attr->newInstance();
                    // Prefer 'input' mapping value
                    $mapKey = is_object($inst->input)
                        ? (string) $inst->input
                        : $inst->input;
                    break;
                }
            }

            if (array_key_exists($mapKey, $input)) {
                $args[$propName] = $input[$mapKey];
            } elseif (array_key_exists($propName, $input)) {
                $args[$propName] = $input[$propName];
            }
        }

        // Fallback: if no promoted properties were found, pass the whole array
        if ($args === []) {
            return new $class(...$input);
        }

        return new $class(...$args);
    }
}
