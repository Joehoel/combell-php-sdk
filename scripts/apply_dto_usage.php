<?php
$map = [
    'src/Requests/SslCertificateRequests/GetSslCertificateRequests.php' => ['list' => true, 'key' => 'items', 'dto' => 'SslCertificateRequest'],
    'src/Requests/SslCertificateRequests/GetSslCertificateRequest.php' => ['list' => false, 'dto' => 'SslCertificateRequestDetail'],
    'src/Requests/Accounts/GetAccounts.php' => ['list' => true, 'key' => 'items', 'dto' => 'Account'],
    'src/Requests/Accounts/GetAccount.php' => ['list' => false, 'dto' => 'AccountDetail'],
    'src/Requests/DnsRecords/GetRecords.php' => ['list' => true, 'key' => 'items', 'dto' => 'DnsRecord'],
    'src/Requests/DnsRecords/GetRecord.php' => ['list' => false, 'dto' => 'DnsRecord'],
    'src/Requests/WindowsHostings/GetWindowsHostings.php' => ['list' => true, 'key' => 'items', 'dto' => 'WindowsHosting'],
    'src/Requests/WindowsHostings/GetWindowsHosting.php' => ['list' => false, 'dto' => 'WindowsHostingDetail'],
    'src/Requests/LinuxHostings/GetLinuxHostings.php' => ['list' => true, 'key' => 'items', 'dto' => 'LinuxHosting'],
    'src/Requests/LinuxHostings/GetLinuxHosting.php' => ['list' => false, 'dto' => 'LinuxHostingDetail'],
    'src/Requests/LinuxHostings/GetAvailablePhpVersions.php' => ['list' => true, 'key' => null, 'dto' => 'PhpVersion'],
    'src/Requests/LinuxHostings/GetSshKeys.php' => ['list' => true, 'key' => null, 'dto' => 'SshKey'],
    'src/Requests/LinuxHostings/GetScheduledTasks.php' => ['list' => true, 'key' => null, 'dto' => 'ScheduledTask'],
    'src/Requests/LinuxHostings/GetScheduledTask.php' => ['list' => false, 'dto' => 'ScheduledTask'],
    'src/Requests/MySqlDatabases/GetMySqlDatabases.php' => ['list' => true, 'key' => 'items', 'dto' => 'MySqlDatabase'],
    'src/Requests/MySqlDatabases/GetMySqlDatabase.php' => ['list' => false, 'dto' => 'MySqlDatabase'],
    'src/Requests/MySqlDatabases/GetDatabaseUsers.php' => ['list' => true, 'key' => null, 'dto' => 'MySqlUser'],
    'src/Requests/Mailboxes/GetMailboxes.php' => ['list' => true, 'key' => null, 'dto' => 'Mailbox'],
    'src/Requests/Mailboxes/GetMailbox.php' => ['list' => false, 'dto' => 'MailboxDetail'],
    'src/Requests/Domains/GetDomains.php' => ['list' => true, 'key' => 'items', 'dto' => 'Domain'],
    'src/Requests/Domains/GetDomain.php' => ['list' => false, 'dto' => 'DomainDetail'],
    'src/Requests/Servicepacks/Servicepacks.php' => ['list' => true, 'key' => null, 'dto' => 'Servicepack'],
    'src/Requests/MailZones/GetMailZone.php' => ['list' => false, 'dto' => 'MailZone'],
    'src/Requests/ProvisioningJobs/GetProvisioningJob.php' => ['list' => false, 'dto' => 'ProvisioningJobInfo'],
    'src/Requests/Ssh/GetAllSshKeys.php' => ['list' => true, 'key' => 'items', 'dto' => 'SshKey'],
    'src/Requests/SslCertificates/GetSslCertificates.php' => ['list' => true, 'key' => 'items', 'dto' => 'SslCertificate'],
    'src/Requests/SslCertificates/GetSslCertificate.php' => ['list' => false, 'dto' => 'SslCertificateDetail'],
    'src/Requests/SslCertificates/DownloadCertificate.php' => ['raw' => true],
];

foreach ($map as $path => $cfg) {
    if (!file_exists($path)) { fwrite(STDERR, "Missing $path\n"); continue; }
    $code = file_get_contents($path);

    // Ensure Response import exists
    if (!str_contains($code, 'use Saloon\\Http\\Response;')) {
        $code = preg_replace('/use\\s+Saloon\\\\Http\\\\Request;/', "use Saloon\\\\Http\\\\Request;\nuse Saloon\\\\Http\\\\Response;", $code, 1);
    }

    // Remove trait import and usage if any remnants
    $code = preg_replace('/^use\\s+Joehoel\\\\Combell\\\\Concerns\\\\MapsToDto;\\s*$/m', '', $code);
    $code = preg_replace('/\n\s*use\s+MapsToDto;\n/', "\n", $code);

    // Remove any existing createDtoFromResponse methods
    $code = preg_replace('/\n\s*public function createDtoFromResponse\(.*?\)\s*:[^{]+\{[\s\S]*?\n\s*\}\n/s', "\n", $code);

    // Generate method
    if (!empty($cfg['raw'])) {
        $method = "\n    public function createDtoFromResponse(Response \$response): string\n    {\n        return \$response->body();\n    }\n";
    } elseif (!empty($cfg['list'])) {
        $jsonExpr = isset($cfg['key']) ? "\$response->json('{$cfg['key']}')" : "\$response->json()";
        $method = "\n    public function createDtoFromResponse(Response \$response): array\n    {\n        return {$cfg['dto']}::collect({$jsonExpr});\n    }\n";
    } else {
        $method = "\n    public function createDtoFromResponse(Response \$response): {$cfg['dto']}\n    {\n        return {$cfg['dto']}::fromResponse(\$response->json());\n    }\n";
    }

    // Insert before final class brace
    $code = preg_replace('/}\s*$/', $method . "\n}\n", $code);

    file_put_contents($path, $code);
}

echo "Applied DTO usage to " . count($map) . " request files\n";
