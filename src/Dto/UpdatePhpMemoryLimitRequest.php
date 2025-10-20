<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class UpdatePhpMemoryLimitRequest extends SpatieData
{
    public function __construct(
        #[MapName('memory_limit')]
        public ?int $memoryLimit = null,
    ) {}
}
