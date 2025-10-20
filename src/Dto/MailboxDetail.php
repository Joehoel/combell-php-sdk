<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class MailboxDetail extends SpatieData
{
    public function __construct(
        public ?string $name = null,
        public ?string $login = null,
        #[MapName('max_size')]
        public ?int $maxSize = null,
        #[MapName('actual_size')]
        public ?int $actualSize = null,
        #[MapName('auto_reply')]
        public ?object $autoReply = null,
        #[MapName('auto_forward')]
        public ?object $autoForward = null,
    ) {}
}
