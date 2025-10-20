<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Data as SpatieData;

/**
 * A detailed representation of an account.
 */
class AccountDetail extends SpatieData
{
    public function __construct(
        public ?int $id = null,
        public ?string $identifier = null,
        public ?object $servicepack = null,
        public ?array $addons = null,
    ) {}
}
