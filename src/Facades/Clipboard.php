<?php

namespace Laragear\Clipboard\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void sear(mixed $value)
 * @method static void copy(mixed $value)
 * @method static mixed paste(mixed $default = null)
 * @method static mixed pull(mixed $default = null)
 * @method static bool clear()
 *
 * @method static \Laragear\Clipboard\Clipboard getFacadeRoot()
 */
class Clipboard extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \Laragear\Clipboard\Clipboard::class;
    }

    /**
     * Retrieves the value, and assigns a null value after.
     *
     * @param  mixed  $value
     * @return void
     */
    public static function cut(mixed &$value): void
    {
        static::getFacadeRoot()->cut($value);
    }
}
