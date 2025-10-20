<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

class PhpVersion extends SpatieData
{
    public function __construct(
        public ?string $version = null,
    ) {}
}
