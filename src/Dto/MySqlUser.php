<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

class MySqlUser extends SpatieData
{
    public function __construct(
        public ?string $name = null,
        public ?string $rights = null,
        public ?bool $enabled = null,
    ) {}
}
