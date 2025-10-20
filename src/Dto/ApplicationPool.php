<?php

namespace Joehoel\Combell\Dto;


/**
 * The application pool for the hosting account.
 */
class ApplicationPool
{
    public function __construct(
        public ?string $runtime = null,
public ?string $pipelineMode = null,
public ?array $installedNetCoreRuntimes = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            runtime: $data['runtime'] ?? null,
            pipelineMode: $data['pipeline_mode'] ?? null,
            installedNetCoreRuntimes: $data['installed_net_core_runtimes'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
