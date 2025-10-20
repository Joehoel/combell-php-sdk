<?php

namespace Joehoel\Combell\Dto;


/**
 * User rights
 */
class UserRights
{
    public function __construct() {}

    public static function fromResponse(array $data): self
    {
        return new self(

        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
