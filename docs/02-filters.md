# Filters

Filters can be used to remove formatted objects from the final result.

Filters are only applied when calling `FormatterInterface::formatMany` or `TraversableFormatterInterface::formatTraversable`.

The callable should be an implementation of the `$callback` parameter defined in the [`array_filter`](https://secure.php.net/manual/en/function.array-filter.php) function. Returning `true` if the element should **not** be filtered.

## Usage

```php
$filter = function (array $data) {
    // Expressions returning true remove the formatted object from the result.
    return $data['count'] !== 126;
};

$formatter->addFilter(filter);
```
