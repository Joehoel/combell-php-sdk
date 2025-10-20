<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Alias extends SpatieData
{
    public function __construct(
        #[MapName('email_address')]
        public ?string $emailAddress = null,
        public ?array $destinations = null,
    ) {}
}
