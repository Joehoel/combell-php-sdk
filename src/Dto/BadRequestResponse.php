<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class BadRequestResponse extends SpatieData
{
    public function __construct(
        #[MapName('validation_errors')]
        public ?array $validationErrors = null,
    ) {}
}
