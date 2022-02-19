<?php

namespace Laragear\Clipboard;

use function value;

class Clipboard
{
    /**
     * Create a new Clipboard instance.
     *
     * @param  mixed  $value
     */
    public function __construct(protected mixed $value = null)
    {
        //
    }

    /**
     * Copies the value into the clipboard.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function copy(mixed $value): mixed
    {
        return $this->value = $value;
    }

    /**
     * Moves the value into the clipboard, assigning it null afterwards.
     *
     * @param  mixed  $value
     * @return void
     */
    public function cut(mixed &$value): void
    {
        $this->copy($value);

        $value = null;
    }

    /**
     * Pastes the value into the context, without removing it from the clipboard.
     *
     * @template TValue
     * @param  TValue|null  $default
     * @return TValue|mixed
     */
    public function paste(mixed $default = null): mixed
    {
        return $this->value ?? value($default);
    }

    /**
     * Moves the value into the context, emptying the clipboard.
     *
     * @template TValue
     * @param  TValue|null  $default
     * @return TValue|mixed
     */
    public function pull(mixed $default = null): mixed
    {
        $result = $this->paste($default);

        $this->clear();

        return $result;
    }

    /**
     * Clears the clipboard
     *
     * @return void
     */
    public function clear(): void
    {
        $this->value = null;
    }
}
