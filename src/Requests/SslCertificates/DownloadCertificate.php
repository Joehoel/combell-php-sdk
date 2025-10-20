<?php

namespace Joehoel\Combell\Requests\SslCertificates;

use Joehoel\Combell\Concerns\MapsToDto;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * DownloadCertificate
 *
 * Returns the certifcate as binary data with the content-type and the filename information in the
 * response headers.
 */
class DownloadCertificate extends Request
{
    use MapsToDto;

    protected Method $method = Method::GET;

    protected bool $dtoRaw = true;

    public function resolveEndpoint(): string
    {
        return "/sslcertificates/{$this->sha1Fingerprint}/download";
    }

    /**
     * @param  string  $sha1Fingerprint  The SHA-1 fingerprint of the certificate.
     * @param  string  $fileFormat  The file format of the returned file stream:
     *                              <ul><li>PFX: Also known as PKCS #12, is a single, password protected certificate archive that contains the entire certificate chain plus the matching private key.</li></ul>
     * @param  string  $password  The password used to protect the certificate file.
     */
    public function __construct(
        protected string $sha1Fingerprint,
        protected string $fileFormat,
        protected string $password,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter([
            'file_format' => $this->fileFormat,
            'password' => $this->password,
        ]);
    }
}
