<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class AntiSpam extends SpatieData
{
    public function __construct(
        public ?string $type = null,
        #[MapName('allowed_types')]
        public ?array $allowedTypes = null,
    ) {}
}
