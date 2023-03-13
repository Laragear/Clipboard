<?php

namespace Laragear\Clipboard;

use Illuminate\Contracts\Http\Kernel as HttpKernelContract;
use Illuminate\Foundation\Http\Kernel as LaravelHttpKernel;
use Illuminate\Support\ServiceProvider;

class ClipboardServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Clipboard::class, static function (): Clipboard {
            return new Clipboard();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @param  \Illuminate\Contracts\Http\Kernel  $kernel
     * @return void
     */
    public function boot(HttpKernelContract $kernel): void
    {
        if ($kernel instanceof LaravelHttpKernel) {
            $kernel->pushMiddleware(Http\Middleware\ClearClipboard::class);
        }
    }
}
