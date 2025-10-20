<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Config;

// Ensure isolated tests and prevent real HTTP requests during tests
uses()
    ->beforeEach(fn() => MockClient::destroyGlobal())
    ->in(__DIR__);

Config::preventStrayRequests();
