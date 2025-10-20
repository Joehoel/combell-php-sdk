<?php

namespace Joehoel\Combell;

use Saloon\Contracts\Authenticator;
use Saloon\Contracts\Body\BodyRepository;
use Saloon\Http\PendingRequest;

class HmacAuthenticator implements Authenticator
{
    public function __construct(
        public readonly string $apiKey,
        public readonly string $apiSecret,
    ) {}

    public function set(PendingRequest $pendingRequest): void
    {
        $time = time();
        $nonce = uniqid();

        $uri = $pendingRequest->getUri();
        $path = (string) $uri->getPath();
        $query = (string) $uri->getQuery();

        if ($query !== '') {
            $path .= '?'.$query;
        }

        if ($path !== urldecode($path)) {
            $path = urldecode($path);
        }

        // Resolve the body into a string if possible
        $bodyString = '';
        $body = $pendingRequest->body();

        if ($body instanceof BodyRepository) {
            if (method_exists($body, '__toString')) {
                $bodyString = (string) $body;
            } else {
                // Fallback to generating a stream and casting to string
                $stream = $body->toStream(
                    $pendingRequest->getFactoryCollection()->streamFactory,
                );
                $bodyString = (string) $stream;
            }
        }

        if ($bodyString !== '') {
            $bodyString = base64_encode(md5($bodyString, true));
        }

        $method = strtolower($pendingRequest->getMethod()->value);

        $valueToSign =
            $this->apiKey.
            $method.
            urlencode($path).
            $time.
            $nonce.
            $bodyString;

        $signedValue = hash_hmac(
            'sha256',
            $valueToSign,
            $this->apiSecret,
            true,
        );
        $signature = base64_encode($signedValue);

        $authorization = sprintf(
            'hmac %s:%s:%s:%s',
            $this->apiKey,
            $signature,
            $nonce,
            $time,
        );

        $pendingRequest->headers()->add('Authorization', $authorization);
    }
}
