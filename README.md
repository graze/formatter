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

Convert objects into arrays of data by applying [processors](docs/10_processors.md), [filters](docs/20_filters.md), and [sorters](docs/30_sorters.md).

```bash
~$ composer require graze/formatter
```

## Usage

```php
// Create a formatter ...
class CountableFormatter extends \Graze\Formatter\AbstractFormatter
{
    protected function generate($object)
    {
        if (! $object instanceof Countable) {
            throw new \InvalidArgumentException(sprintf('`$object` must be an instance of %s.', Countable::class));
        }

        return [
            'count' => $object->count(),
        ];
    }
}

// ... processor ...
$processor = function (array $data, Countable $object) {
    // Let's add the square of count.
    $data['square'] = $data['count'] ** 2;

    return $data;
};

// ... filter ...
$filter = function (array $data) {
    // Remove elements with a count of 126.
    return $data['count'] !== 126;
};

// ... sorter ...
$sorter = function (array $data) {
    // Sort by count in descending order.
    return $data['count'] * -1;
};

// ... and something we can format.
class ExampleCountable implements Countable
{
    private $count = 0;

    public function count()
    {
        return $this->count += 1;
    }
}

$countable = new ExampleCountable();

// Create a new instance of the formatter, and register all the callables.
$formatter = new CountableFormatter();
$formatter->addProcessor($processor);
$formatter->addFilter($filter);
$formatter->addSorter($sorter);

// Format a single object.
$result = $formatter->format($countable);

print_r($result);

// Format several objects.
$result = $formatter->formatMany([$countable, $countable, $countable]);

print_r($result);
```

The above example will output:

```
Array
(
    [count] => 1
    [square] => 1
)
Array
(
    [0] => Array
        (
            [count] => 4
            [square] => 16
        )

    [1] => Array
        (
            [count] => 3
            [square] => 9
        )

    [2] => Array
        (
            [count] => 2
            [square] => 4
        )

)
```

Find more documentation under [`docs/`](/docs).
