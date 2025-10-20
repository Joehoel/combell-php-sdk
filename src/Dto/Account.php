<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Account extends SpatieData
{
    public function __construct(
        public ?int $id = null,
        public ?string $identifier = null,
        #[MapName('servicepack_id')] public ?int $servicepackId = null,
    ) {}
}
