<?php

namespace Joehoel\Combell\Dto;


class SslCertificateRequestValidation
{
    public function __construct(
public ?string $dnsName = null,
        public ?string $type = null,
public ?bool $autoValidated = null,
public ?array $emailAddresses = null,
public ?string $cnameValidationName = null,
public ?string $cnameValidationContent = null,
public ?string $fileValidationUrlHttp = null,
public ?string $fileValidationUrlHttps = null,
public ?array $fileValidationContent = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            dnsName: $data['dns_name'] ?? null,
            type: $data['type'] ?? null,
            autoValidated: $data['auto_validated'] ?? null,
            emailAddresses: $data['email_addresses'] ?? [],
            cnameValidationName: $data['cname_validation_name'] ?? null,
            cnameValidationContent: $data['cname_validation_content'] ?? null,
            fileValidationUrlHttp: $data['file_validation_url_http'] ?? null,
            fileValidationUrlHttps: $data['file_validation_url_https'] ?? null,
            fileValidationContent: $data['file_validation_content'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }

}
