<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

class AutoReply extends SpatieData
{
    public function __construct(
        public ?bool $enabled = null,
        public ?string $subject = null,
        public ?string $message = null,
    ) {}
}
