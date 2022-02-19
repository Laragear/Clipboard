<?php

namespace Tests;

use Laragear\Clipboard\ClipboardServiceProvider;
use Laragear\Clipboard\Facades\Clipboard;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [ClipboardServiceProvider::class];
    }

    protected function getPackageAliases($app):array
    {
        return ['Clipboard' => Clipboard::class];
    }
}
