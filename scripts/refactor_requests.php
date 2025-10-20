<?php

$dir = __DIR__.'/../src/Requests';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$changed = 0;
foreach ($files as $file) {
    if (! $file->isFile()) {
        continue;
    }
    if (pathinfo($file->getFilename(), PATHINFO_EXTENSION) !== 'php') {
        continue;
    }

    $path = $file->getPathname();
    $code = file_get_contents($path);

    if (strpos($code, 'use Joehoel\\Combell\\Concerns\\MapsToDto;') === false) {
        continue; // skip non-mapping requests
    }

    $original = $code;

    // Detect if raw body mapping
    $isRaw = str_contains($code, '$dtoRaw = true');

    // Detect DTO class via import
    $dtoClass = null;
    if (preg_match('/use\\s+Joehoel\\\\Combell\\\\Dto\\\\(\\w+)\\s*;/', $code, $m)) {
        $dtoClass = $m[1];
    }

    // Detect list & collection key
    $isList = str_contains($code, '$dtoIsList = true');
    $collectionKey = null;
    if (preg_match('/\\$dtoCollectionKey\\s*=\\s*\'([^\']+)\'\\s*;/', $code, $m2)) {
        $collectionKey = $m2[1];
    } elseif (preg_match('/\\$dtoCollectionKey\\s*=\\s*null\\s*;/', $code)) {
        $collectionKey = null; // explicitly null
    }

    // Remove MapsToDto import (robust across whitespace)
    $code = preg_replace('/^use\\s+Joehoel\\\\Combell\\\\Concerns\\\\MapsToDto;\\s*$/m', '', $code);

    // Ensure Response import
    if (! str_contains($code, 'use Saloon\\Http\\Response;')) {
        $code = preg_replace('/use\\s+Saloon\\\\Http\\\\Request;/', "use Saloon\\\\Http\\\\Request;\nuse Saloon\\\\Http\\\\Response;", $code, 1);
    }

    // Remove trait usage line inside class
    $code = preg_replace('/\n\s*use\s+MapsToDto;\n/', "\n", $code);

    // Remove dtoClass/dtoIsList/dtoCollectionKey/dtoRaw property lines
    $code = preg_replace('/\n\s*protected\s+\?string\s+\$dtoClass\s*=\s*[^;]+;\n/s', "\n", $code);
    $code = preg_replace('/\n\s*protected\s+bool\s+\$dtoIsList\s*=\s*true;\n/s', "\n", $code);
    $code = preg_replace('/\n\s*protected\s+\?string\s+\$dtoCollectionKey\s*=\s*[^;]+;\n/s', "\n", $code);
    $code = preg_replace('/\n\s*protected\s+bool\s+\$dtoRaw\s*=\s*true;\n/s', "\n", $code);

    // Remove any existing createDtoFromResponse methods to avoid duplicates
    $code = preg_replace('/\n\s*public function createDtoFromResponse\(.*?\)\s*:[^{]+\{[\s\S]*?\n\s*\}\n/s', "\n", $code);

    // Build createDtoFromResponse method
    $method = '';
    if ($isRaw) {
        $method = "\n    public function createDtoFromResponse(Response \$response): string\n    {\n        return \$response->body();\n    }\n";
    } elseif ($isList) {
        if ($dtoClass === null) {
            // No DTO? fallback to array
            $method = "\n    public function createDtoFromResponse(Response \$response): array\n    {\n        return (array) (\$response->json() ?? []);\n    }\n";
        } else {
            $jsonExpr = $collectionKey === null ? '$response->json()' : "\$response->json('{$collectionKey}')";
            $method = "\n    public function createDtoFromResponse(Response \$response): array\n    {\n        return {$dtoClass}::collect({$jsonExpr});\n    }\n";
        }
    } else {
        if ($dtoClass === null) {
            // Fallback: return json as array
            $method = "\n    public function createDtoFromResponse(Response \$response): array\n    {\n        return (array) (\$response->json() ?? []);\n    }\n";
        } else {
            $method = "\n    public function createDtoFromResponse(Response \$response): {$dtoClass}\n    {\n        return {$dtoClass}::fromResponse(\$response->json());\n    }\n";
        }
    }

    // Insert method before final closing brace of class file
    $code = preg_replace('/}\s*$/', $method."\n}\n", $code);

    if ($code !== $original) {
        file_put_contents($path, $code);
        $changed++;
    }
}

fwrite(STDOUT, "Updated $changed request files\n");
