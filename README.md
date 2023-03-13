# Clipboard 
[![Latest Version on Packagist](https://img.shields.io/packagist/v/laragear/clipboard.svg)](https://packagist.org/packages/laragear/clipboard)
[![Latest stable test run](https://github.com/Laragear/Clipboard/workflows/Tests/badge.svg)](https://github.com/Laragear/Clipboard/actions)
[![Codecov coverage](https://codecov.io/gh/Laragear/Clipboard/branch/1.x/graph/badge.svg?token=Io2axyOxnY)](https://codecov.io/gh/Laragear/Clipboard)
[TODO: Add CodeClimate badge] [![Laravel Octane Compatibility](https://img.shields.io/badge/Laravel%20Octane-Compatible-success?style=flat&logo=laravel)](https://laravel.com/docs/9.x/octane#introduction)

Copy, cut & paste in your application. You read that right.

```php
use Laragear\Clipboard\Facades\Clipboard;

public function foo()
{
    Clipboard::copy('test');
}

public function bar()
{
    Clipboard::paste(); // 'test'
}
```

## Become a sponsor

[![](.github/assets/support.png)](https://github.com/sponsors/DarkGhostHunter)

Your support allows me to keep this package free, up-to-date and maintainable. Alternatively, you can **[spread the word!](http://twitter.com/share?text=I%20am%20using%20this%20cool%20PHP%20package&url=https://github.com%2FLaragear%2FClipboard&hashtags=PHP,Laravel,FoolsDay)**

## Requirements

* PHP 8 or later
* Laravel 9, 10 or later 

## Installation

You can install the package via composer:

```bash
composer require laragear/clipboard
```

## Usage

The Clipboard works like your normal clipboard in your application.

| Method    | Description                                                                   |
|-----------|-------------------------------------------------------------------------------|
| `copy()`  | Copies a value into the clipboard.                                            |
| `cut()`   | Moves a value into the clipboard, assigning it `null` on the current context. |
| `clone()` | Clones an object into the clipboard.                                          |
| `paste()` | Pastes a value previously copied in the clipboard.                            |
| `pull()`  | Pastes a value previously copied, removing it from the Clipboard.             |
| `clear()` | Clears the clipboard value.                                                   |

Using the Clipboard to move around values inside the application allows you to avoid registering things into the Service Container unnecessarily, or moving a value around using functions or the cache.

### Copy and paste

Copying a value will copy the reference of the object, or the value if is a primitive like a `string`, `int` or an `array`, among others. It works like any other function.

```php
use Laragear\Clipboard\Facades\Clipboard;
use App\Models\Article;

$article = Article::find(5);

// Copy a value
Clipboard::copy($article);

// Edit the reference after has been copied.
$article->title = 'The new title!';
```

Pasting will paste the value how many times you want. It accepts a default value in case the clipboard is empty.

```php
// Paste a value
Clipboard::paste()->title; // 'The new title'
```

#### Clone

Sometimes you may want to actually _clone_ the object instead of copy its reference. For these cases, use the `clone()` method.

```php
use Laragear\Clipboard\Facades\Clipboard;
use App\Models\Article;

$article = Article::make(['title' => 'Original title']);

// Clone an object
Clipboard::clone($article);
```

Since it's a clone, the original variable will be different from the one pasted afterward.

```php
$article->title = 'Different title';

echo Clipboard::paste()->title; // "Original title"
```

### Cut and pull

Cut works like copy, but the value in the current context will be assigned `null`.

```php
use Laragear\Clipboard\Facades\Clipboard;

$article = 'This is a big wall of text.';

// Cut a value
Clipboard::cut($article);

echo $article; // ''
```

Meanwhile, `pull()`, will retrieve the value from the Clipboard and remove it from there. It accepts a default value in case the clipboard is empty.

```php
use Laragear\Clipboard\Facades\Clipboard;

$text = Clipboard::pull();

echo $text; // 'This is a big wall of text.'
```

### Clearing

You can clear the Clipboard anytime using `clear()`:

```php
use Laragear\Clipboard\Facades\Clipboard;

Clipboard::copy('I am going to dissapear.');

Clipboard::clear();

echo Clipboard::paste(); // ''
```

### Method pass-through

For your convenience, you don't need to retrieve the Clipboard object to do something. The Clipboard will pass through all methods calls to the copied or cloned object.

```php
use Laragear\Clipboard\Facades\Clipboard;
use App\Models\Article;

$article = Article::make(['title' => 'Original title']);

// Copy a value
Clipboard::copy($article);

// Some lines after...
Clipboard::save();
```

## How this works?

It just registers a singleton that holds a value during the life of the request, or the entirety of the command. That's it.

## Laravel Octane compatibility

- There are no singletons using a stale application instance.
- There are no singletons using a stale config instance.
- There are no singletons using a stale request instance.
- There are no static properties written during a request.

There should be no problems using this package with Laravel Octane.

## Security

If you discover any security related issues, please email darkghosthunter@gmail.com instead of using the issue tracker.

# License

This specific package version is licensed under the terms of the [MIT License](LICENSE.md), at time of publishing.

[Laravel](https://laravel.com) is a Trademark of [Taylor Otwell](https://github.com/TaylorOtwell/). Copyright © 2011-2023 Laravel LLC.
