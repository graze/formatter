# Filters

Filters can be used to remove formatted objects from the final result.

Filters are only applied when calling `FormatterInterface::formatMany` or `FormatterInterface::formatTraversable`.

## Usage

```php
$filter = function (array $data) {
    // Expressions returning true remove the formatted object from the result.
    return $data['count'] !== 126;
};

$formatter->addFilter(filter);
```
