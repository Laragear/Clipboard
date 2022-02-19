<?php

namespace Tests;

use Illuminate\Support\Fluent;
use Laragear\Clipboard\Clipboard as RealClipboard;
use Laragear\Clipboard\Facades\Clipboard;

class ClipboardTest extends TestCase
{
    protected RealClipboard $clipboard;

    protected function setUp(): void
    {
        parent::setUp();

        $this->clipboard = $this->app->make(RealClipboard::class);
    }

    public function test_cuts_value(): void
    {
        $value = 'test';

        Clipboard::cut($value);

        static::assertNull($value);

        static::assertSame('test', $this->clipboard->paste());
    }

    public function test_cuts_reference(): void
    {
        $object = new Fluent(['foo' => 'bar']);

        Clipboard::cut($object);

        static::assertNull($object);

        static::assertEquals(new Fluent(['foo' => 'bar']), $this->clipboard->paste());
    }

    public function test_copy_and_paste(): void
    {
        $object = new Fluent(['foo' => 'bar']);

        Clipboard::copy($object);

        static::assertSame($object, $this->clipboard->paste());
        static::assertSame($object, $this->clipboard->paste());
    }

    public function test_cut_and_pull(): void
    {
        $object = new Fluent(['foo' => 'bar']);

        Clipboard::cut($object);

        static::assertEquals(new Fluent(['foo' => 'bar']), $this->clipboard->pull());
        static::assertNull($this->clipboard->paste());
    }

    public function test_paste_uses_default(): void
    {
        static::assertSame('foo', $this->clipboard->paste('foo'));
        static::assertSame('bar', $this->clipboard->paste(fn() => 'bar'));
    }

    public function test_pull_uses_default(): void
    {
        static::assertSame('foo', $this->clipboard->pull('foo'));
        static::assertSame('bar', $this->clipboard->pull(fn() => 'bar'));
    }
}
