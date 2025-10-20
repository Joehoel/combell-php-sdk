<?php

namespace Joehoel\Combell\Concerns;

use Saloon\Http\Response;

/**
 * Provides a default implementation for Saloon's createDtoFromResponse
 * allowing requests to declare a DTO class and whether the response
 * is a list (optionally under a specific JSON key like 'items').
 */
trait MapsToDto
{
    /** @var null|string Fully qualified DTO class name */
    protected ?string $dtoClass = null;

    /** @var bool Whether the response is a list of DTOs */
    protected bool $dtoIsList = false;

    /** @var null|string JSON key that contains the list (e.g. 'items') */
    protected ?string $dtoCollectionKey = null;

    /** @var bool When true, returns the raw response body (e.g. downloads) */
    protected bool $dtoRaw = false;

    public function createDtoFromResponse(Response $response): mixed
    {
        if ($this->dtoRaw === true) {
            return $response->body();
        }

        $status = $response->status();
        $body = $response->body();

        if ($status === 204 || $body === '' || $body === null) {
            return null;
        }

        if ($this->dtoClass === null) {
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

        $class = $this->dtoClass;

        if ($this->dtoIsList === true) {
            $items = $data;
            if (is_array($data) && $this->dtoCollectionKey !== null) {
                $items = $data[$this->dtoCollectionKey] ?? [];
            }

            if (! is_array($items)) {
                return [];
            }

            return array_map(static function ($item) use ($class) {
                if (method_exists($class, 'from')) {
                    return $class::from($item);
                }

                return new $class(...(array) $item);
            }, $items);
        }

        if (method_exists($class, 'from')) {
            return $class::from($data);
        }

        return new $class(...(array) $data);
    }
}
