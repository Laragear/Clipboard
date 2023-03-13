<?php

namespace Tests;

use Illuminate\Console\BufferedConsoleOutput;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Console\OutputStyle;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Env;
use Laragear\Clipboard\Facades\Clipboard;
use Symfony\Component\Console\Input\StringInput;

class ClipboardClearingTest extends TestCase
{
    protected function tearDown(): void
    {
        Env::getRepository()->set('APP_RUNNING_IN_CONSOLE', true);

        parent::tearDown();
    }

    public function test_clears_clipboard_after_response_sent(): void
    {
        Env::getRepository()->set('APP_RUNNING_IN_CONSOLE', false);

        $this->refreshApplication();

        Clipboard::copy('foo');

        $this->app->make(Dispatcher::class)->dispatch(RequestHandled::class, [
            new Request(),
            new Response(),
        ]);

        static::assertNull(Clipboard::paste());
    }

    public function test_clears_clipboard_after_command_finishes(): void
    {
        Env::getRepository()->set('APP_RUNNING_IN_CONSOLE', true);

        $this->refreshApplication();

        Clipboard::copy('foo');

        $this->app->make(Dispatcher::class)->dispatch(CommandFinished::class, [
            'test',
            new StringInput(''),
            new OutputStyle(new StringInput(''), new BufferedConsoleOutput()),
            0
        ]);

        static::assertNull(Clipboard::paste());
    }
}
