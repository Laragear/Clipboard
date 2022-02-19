<?php

namespace Laragear\Clipboard;

use Illuminate\Support\Traits\ForwardsCalls;
use function value;

class Clipboard
{
    use ForwardsCalls;

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
     * @template TValue
     * @param  TValue|mixed  $value
     * @return TValue|mixed
     */
    public function copy(mixed $value): mixed
    {
        return $this->value = $value;
    }

    /**
     * Clones the object into the clipboard
     *
     * @template TValue
     * @param  TValue|mixed  $value
     * @return TValue|mixed
     */
    public function clone(object $value): mixed
    {
        return $this->value = clone $value;
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

    /**
     * Pass through all methods to the copied value object.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return void
     */
    public function __call(string $method, array $parameters)
    {
        return $this->forwardCallTo($this->value, $method, $parameters);
    }
}
