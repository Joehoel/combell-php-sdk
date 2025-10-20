<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

class CreateMySqlUser extends SpatieData
{
    public function __construct(
        public ?string $name = null,
        public ?string $password = null,
    ) {}
}
