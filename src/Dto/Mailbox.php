<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Mailbox extends SpatieData
{
    public function __construct(
        public ?string $name = null,
        #[MapName('max_size')]
        public ?int $maxSize = null,
        #[MapName('actual_size')]
        public ?int $actualSize = null,
    ) {}
}
