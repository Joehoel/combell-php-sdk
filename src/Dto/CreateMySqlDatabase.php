<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class CreateMySqlDatabase extends SpatieData
{
    public function __construct(
        #[MapName('database_name')]
        public ?string $databaseName = null,
        #[MapName('account_id')]
        public ?int $accountId = null,
        public ?string $password = null,
    ) {}
}
