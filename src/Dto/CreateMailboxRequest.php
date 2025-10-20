<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class CreateMailboxRequest extends SpatieData
{
    public function __construct(
        #[MapName('email_address')]
        public ?string $emailAddress = null,
        #[MapName('account_id')]
        public ?int $accountId = null,
        public ?string $password = null,
    ) {}
}
