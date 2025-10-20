<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

class CompletionEstimation extends SpatieData
{
    public function __construct(
        public ?string $estimate = null,
    ) {}
}
