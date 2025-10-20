<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class AddSubsiteRequest extends SpatieData
{
    public function __construct(
        #[MapName('domain_name')]
        public ?string $domainName = null,
        public ?string $path = null,
    ) {}
}
