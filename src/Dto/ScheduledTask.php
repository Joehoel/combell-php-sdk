<?php

namespace Joehoel\Combell\Dto;


class ScheduledTask
{
    public function __construct(
        public ?string $id = null,
        public ?bool $enabled = null,
public ?string $cronExpression = null,
public ?string $scriptLocation = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            enabled: $data['enabled'] ?? null,
            cronExpression: $data['cron_expression'] ?? null,
            scriptLocation: $data['script_location'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
