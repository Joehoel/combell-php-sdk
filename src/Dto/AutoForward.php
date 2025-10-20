<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class AutoForward extends SpatieData
{
    public function __construct(
        public ?bool $enabled = null,
        #[MapName('email_addresses')]
        public ?array $emailAddresses = null,
        #[MapName('copy_to_myself')]
        public ?bool $copyToMyself = null,
    ) {}
}
