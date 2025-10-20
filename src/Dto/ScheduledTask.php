<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class ScheduledTask extends SpatieData
{
    public function __construct(
        public ?string $id = null,
        public ?bool $enabled = null,
        #[MapName('cron_expression')]
        public ?string $cronExpression = null,
        #[MapName('script_location')]
        public ?string $scriptLocation = null,
    ) {}
}
