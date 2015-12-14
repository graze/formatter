# graze/formatter [![Build Status][ico-travis]][travis] [![Latest Version][ico-packagist]][packagist] [![MIT Licensed][ico-license]][license]

<!-- Images -->
[ico-travis]: https://img.shields.io/travis/graze/formatter/master.svg
[ico-packagist]: https://img.shields.io/packagist/v/graze/formatter.svg
[ico-license]: https://img.shields.io/packagist/l/graze/formatter.svg

<!-- Links -->
[travis]: https://travis-ci.org/graze/formatter
[packagist]: https://packagist.org/packages/graze/formatter
[license]: https://github.com/graze/formatter/blob/master/LICENSE

Convert objects into arrays of data by applying [processors](docs/01-processors.md), [filters](docs/02-filters.md), and [sorters](docs/03-sorters.md).

Read more about why we made this library in our [blog post](http://tech.graze.com/2015/12/10/graze-formatter/).

## Installation

We recommend installing this library with [Composer](https://getcomposer.org).

```bash
~$ composer require graze/formatter
```

## Usage

```php
// Create a formatter ...
class CountableFormatter extends \Graze\Formatter\AbstractFormatter
{
    protected function convert($object)
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
    // Remove elements with a square of 9.
    return $data['square'] !== 9;
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
            [count] => 2
            [square] => 4
        )

)
```

Find more documentation under [`docs/`](/docs).
