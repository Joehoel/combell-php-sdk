<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

class CreateSmtpDomainRequest extends SpatieData
{
    public function __construct(
        public ?string $hostname = null,
    ) {}
}
