<?php

namespace Joehoel\Combell\Dto;


class ValidationErrorMessage
{
    public function __construct(
public ?string $errorCode = null,
public ?string $errorText = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            errorCode: $data['error_code'] ?? null,
            errorText: $data['error_text'] ?? null,
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
