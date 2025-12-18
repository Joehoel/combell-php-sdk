<?php

use Saloon\Http\Request;

it('will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->not->toBeUsed();

it('ensures every request class extends Saloon Request', function () {
    $requestsPath = realpath(__DIR__.'/../src/Requests');
    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($requestsPath));

    foreach ($files as $file) {
        if ($file->isDir() || $file->getExtension() !== 'php') {
            continue;
        }

        $relative = substr($file->getPathname(), strlen($requestsPath) + 1);
        $classPath = str_replace(['/', '\\'], '\\', $relative);
        $classPath = str_replace('.php', '', $classPath);
        $class = 'Joehoel\\Combell\\Requests\\'.$classPath;

        if (! class_exists($class)) {
            continue;
        }

        expect(is_subclass_of($class, Request::class))
            ->toBeTrue("{$class} must extend ".Request::class);
    }
});

