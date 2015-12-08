# Sorters

Sorters can be used to sort the final result.

Sorters are only applied when calling `FormatterInterface::formatMany`.

## Usage

```php
$sorter = function (array $data) {
    // Sort by count in descending order.
    return $data['count'] * -1;
};

$formatter->addSorter($sorter);
```
