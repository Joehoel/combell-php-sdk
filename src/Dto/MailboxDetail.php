<?php

namespace Joehoel\Combell\Dto;


class MailboxDetail
{
    public function __construct(
        public ?string $name = null,
        public ?string $login = null,
public ?int $maxSize = null,
public ?int $actualSize = null,
public ?object $autoReply = null,
public ?object $autoForward = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            login: $data['login'] ?? null,
            maxSize: $data['max_size'] ?? null,
            actualSize: $data['actual_size'] ?? null,
            autoReply: $data['auto_reply'] ?? null,
            autoForward: $data['auto_forward'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
