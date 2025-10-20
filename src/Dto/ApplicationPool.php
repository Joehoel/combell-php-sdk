<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

/**
 * The application pool for the hosting account.
 */
class ApplicationPool extends SpatieData
{
    public function __construct(
        public ?string $runtime = null,
        #[MapName('pipeline_mode')]
        public ?string $pipelineMode = null,
        #[MapName('installed_net_core_runtimes')]
        public ?array $installedNetCoreRuntimes = null,
    ) {}
}
