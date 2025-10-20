<?php

namespace Joehoel\Combell\Dto;

/**
 * Type of the hosting IP address (dedicated or shared)
 */
class WindowsIpType
{
    public function __construct() {}

    public static function fromResponse(array $data): self
    {
        return new self;
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
