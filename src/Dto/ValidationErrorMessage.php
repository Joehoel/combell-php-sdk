<?php

namespace Joehoel\Combell\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class ValidationErrorMessage extends SpatieData
{
    public function __construct(
        #[MapName('error_code')]
        public ?string $errorCode = null,
        #[MapName('error_text')]
        public ?string $errorText = null,
    ) {}
}
