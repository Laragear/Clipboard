<?php

namespace Http\Middleware;

use Laragear\Clipboard\Facades\Clipboard;
use Tests\TestCase;

class ClearClipboardTest extends TestCase
{
    protected function defineRoutes($router): void
    {
        $router->get('pastes', function () {
            return Clipboard::paste('not-found');
        });
    }

    public function test_clears_clipboard_after_response_sent(): void
    {
        Clipboard::copy('foo');

        $this->get('pastes')->assertSee('foo');

        static::assertNull(Clipboard::paste());
    }
}
