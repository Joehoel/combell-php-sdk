<?php

namespace Joehoel\Combell\Dto;


class AutoReply
{
    public function __construct(
        public ?bool $enabled = null,
        public ?string $subject = null,
        public ?string $message = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            enabled: $data['enabled'] ?? null,
            subject: $data['subject'] ?? null,
            message: $data['message'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
