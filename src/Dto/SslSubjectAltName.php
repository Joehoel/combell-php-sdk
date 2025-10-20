<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

class SslSubjectAltName extends SpatieData
{
    public function __construct(
        public ?string $type = null,
        public ?string $value = null,
    ) {}
}
