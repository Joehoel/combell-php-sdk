<?php

use Joehoel\Combell\Combell;
use Joehoel\Combell\HmacAuthenticator;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Test-only request that exercises URL encoding/decoding rules.
 */
class DummyGetRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        // Intentionally include encoded braces and a space in the path
        return "/dummy/%7Bencoded%7D path";
    }

    public function defaultQuery(): array
    {
        // Space in value to exercise query encoding
        return ["q" => "a b"];
    }
}

/**
 * Test-only POST request with JSON body.
 */
class DummyPostJsonRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/dummy/json";
    }
}

it("signs GET requests and sets default headers", function () {
    $mock = new MockClient([
        DummyGetRequest::class => MockResponse::make("{}", 200, [
            "Content-Type" => "application/json",
        ]),
    ]);

    $apiKey = "key_123";
    $apiSecret = "secret_456";

    $sdk = Combell::fake($mock, $apiKey, $apiSecret);

    $response = $sdk->send(new DummyGetRequest());
    expect($response->status())->toBe(200);

    $pending = $mock->getLastPendingRequest();
    expect($pending)->not->toBeNull();

    $authHeader = $pending->headers()->get("Authorization");
    expect($authHeader)->toStartWith("hmac ");

    // Parse header: hmac {apiKey}:{signature}:{nonce}:{time}
    $parts = explode(" ", $authHeader, 2);
    $creds = explode(":", $parts[1]);
    expect(count($creds))->toBe(4);

    [$headerKey, $headerSignature, $nonce, $time] = $creds;
    expect($headerKey)->toBe($apiKey);

    $uri = $pending->getUri();
    $path = (string) $uri->getPath();
    $query = (string) $uri->getQuery();
    if ($query !== "") {
        $path .= "?" . $query;
    }
    if ($path !== urldecode($path)) {
        $path = urldecode($path);
    }

    $method = strtolower($pending->getMethod()->value);
    $bodyString = "";

    $valueToSign =
        $apiKey . $method . urlencode($path) . $time . $nonce . $bodyString;
    $expectedSignature = base64_encode(
        hash_hmac("sha256", $valueToSign, $apiSecret, true),
    );

    expect($headerSignature)->toBe($expectedSignature);

    // Default headers from the connector
    expect($pending->headers()->get("Accept"))->toBe("application/json");
    expect($pending->headers()->get("Content-Type"))->toBe("application/json");
});

it("includes JSON body hash in signature for POST", function () {
    $mock = new MockClient([
        DummyPostJsonRequest::class => MockResponse::make("{}", 200, [
            "Content-Type" => "application/json",
        ]),
    ]);

    $apiKey = "key_post";
    $apiSecret = "secret_post";

    $sdk = Combell::fake($mock, $apiKey, $apiSecret);

    $request = new DummyPostJsonRequest();
    $request->body()->merge(["name" => "Alice", "age" => 30]);

    $response = $sdk->send($request);
    expect($response->status())->toBe(200);

    $pending = $mock->getLastPendingRequest();
    expect($pending)->not->toBeNull();

    $authHeader = $pending->headers()->get("Authorization");
    $creds = explode(":", explode(" ", $authHeader, 2)[1]);
    [$headerKey, $headerSignature, $nonce, $time] = $creds;
    expect($headerKey)->toBe($apiKey);

    $uri = $pending->getUri();
    $path = (string) $uri->getPath();
    $query = (string) $uri->getQuery();
    if ($query !== "") {
        $path .= "?" . $query;
    }
    if ($path !== urldecode($path)) {
        $path = urldecode($path);
    }

    $method = strtolower($pending->getMethod()->value);

    // The authenticator hashes the string representation of the BodyRepository
    $jsonString = (string) $pending->body();
    $bodyString = base64_encode(md5($jsonString, true));

    $valueToSign =
        $apiKey . $method . urlencode($path) . $time . $nonce . $bodyString;
    $expectedSignature = base64_encode(
        hash_hmac("sha256", $valueToSign, $apiSecret, true),
    );

    expect($headerSignature)->toBe($expectedSignature);
});
