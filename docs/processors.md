# Processors

```php
$processor = function (array $data, $item) {
    $data['class'] = get_class($item);

    return $data;
};

$formatter->addProcessor($processor);
```

The above example will output:

```
Array
(
    [count] => 42
    [class] => MeaningOfLifeCountable
)
```
