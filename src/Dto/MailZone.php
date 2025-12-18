<?php

namespace Joehoel\Combell\Dto;

class MailZone
{
    public function __construct(
        public ?string $name = null,
        public ?bool $enabled = null,
        public ?array $availableAccounts = null,
        public ?array $aliases = null,
        public ?object $antiSpam = null,
        public ?object $catchAll = null,
        public ?array $smtpDomains = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        $antiSpam = $data['anti_spam'] ?? null;
        if (is_array($antiSpam)) {
            $antiSpam = (object) $antiSpam;
        }

        $catchAll = $data['catch_all'] ?? null;
        if (is_array($catchAll)) {
            $catchAll = (object) $catchAll;
        }

        return new self(
            name: $data['name'] ?? null,
            enabled: $data['enabled'] ?? null,
            availableAccounts: $data['available_accounts'] ?? [],
            aliases: $data['aliases'] ?? [],
            antiSpam: $antiSpam,
            catchAll: $catchAll,
            smtpDomains: $data['smtp_domains'] ?? [],
        );
    }

    public static function collect(array $items): array
    {
        return array_map(fn (array $item) => self::fromResponse($item), $items);
    }
}
