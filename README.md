# graze/formatter

[![Build Status][ico-build]][travis]
[![Latest Version][ico-package]][package]
[![PHP ~5.6][ico-engine]][lang]
[![MIT Licensed][ico-license]][license]

<!-- Links -->
[travis]: https://travis-ci.org/graze/queue
[lang]: https://secure.php.net
[package]: https://packagist.org/packages/graze/queue
[license]: https://github.com/graze/queue/blob/master/LICENSE

<!-- Images -->
[ico-license]: https://img.shields.io/packagist/l/graze/formatter.svg
[ico-package]: https://img.shields.io/packagist/v/graze/formatter.svg
[ico-build]: https://img.shields.io/travis/graze/formatter/master.svg
[ico-engine]: https://img.shields.io/badge/php-%3E%3D5.6-8892BF.svg

Convert objects into data arrays.

```bash
~$ composer require graze/formatter
```

## Usage

```php
// Create a concrete formatter ...
class CountableFormatter extends \Graze\Formatter\AbstractFormatter
{
    protected function generate($item)
    {
        if (! $item instanceof Countable) {
            throw new \InvalidArgumentException(sprintf('`$item` must be an instance of %s.', Countable::class));
        }

        return [
            'count' => $item->count(),
        ];
    }
}

// ... and something we can format.
class MeaningOfLifeCountable implements Countable
{
    public function count()
    {
        return 42;
    }
}

$countable = new MeaningOfLifeCountable();
$formatter = new CountableFormatter();

// Format a single item.
$result = $formatter->format($countable);

print_r($result);

// Format several items.
$result = $formatter->formatMany([$countable, $countable, $countable]);

print_r($result);
```

The above example will output:

```
Array
(
    [count] => 42
)
Array
(
    [0] => Array
        (
            [count] => 42
        )

    [1] => Array
        (
            [count] => 42
        )

    [2] => Array
        (
            [count] => 42
        )

)
```

Find more examples in the [`examples/`](/examples) folder, and more documentation under [`docs/`](/docs).
