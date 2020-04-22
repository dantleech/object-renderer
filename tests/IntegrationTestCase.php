<?php

namespace Phpactor\ObjectRenderer\Tests;

use PHPUnit\Framework\TestCase;
use Phpactor\TestUtils\Workspace;

class IntegrationTestCase extends TestCase
{
    protected function loadStub(string $name): object
    {
        return require __DIR__ . '/Stub/' . $name;
    }

    protected function workspace(): Workspace
    {
        return Workspace::create(__DIR__ . '/Workspace');
    }
}
