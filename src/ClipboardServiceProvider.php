<?php

namespace Laragear\Clipboard;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Events\Dispatcher as EventContract;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Support\ServiceProvider;
use function app;

class ClipboardServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Clipboard::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function boot(EventContract $events): void
    {
        $event = $this->app->runningInConsole() ? CommandFinished::class : RequestHandled::class;

        $events->listen($event, static function () {
            app(Clipboard::class)->clear();
        });
    }
}
