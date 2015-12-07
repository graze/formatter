# Sorters

```php
// Create a processor we can sort with.
$position = 0;
$processor = function (array $data, $item) use (&$position) {
    $data['position'] = $position++;

    return $data;
};
$formatter->addProcessor($processor);

// Reverse the order of the result using a sorter.
$sorter = function (array $data) {
    return -$data['position'];
};

$formatter->addSorter($sorter);

$result = $formatter->formatMany([$countable, $countable, $countable]);

print_r($result);
```

The above example will output:

```
Array
(
    [0] => Array
        (
            [count] => 42
            [position] => 2
        )

    [1] => Array
        (
            [count] => 42
            [position] => 1
        )

    [2] => Array
        (
            [count] => 42
            [position] => 0
        )

)
```
