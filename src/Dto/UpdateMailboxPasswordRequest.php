<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

class UpdateMailboxPasswordRequest extends SpatieData
{
    public function __construct(
        public ?string $password = null,
    ) {}
}
