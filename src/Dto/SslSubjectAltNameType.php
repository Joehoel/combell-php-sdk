<?php

namespace Joehoel\Combell\Dto;


/**
 * The type of the alt name:
 * <ul><li>Dns</li><li>Ip</li></ul>
 */
class SslSubjectAltNameType
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
