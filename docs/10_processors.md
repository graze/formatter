# Processors

## Using Anonymous Functions

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

## Using Graze\Formatter\AbstractProcessor

```
use Graze\Formatter\AbstractProcessor;

final class ClassNameProcessor extends AbstractProcessor
{
    protected function process(array $data, $item)
    {
        $data['class'] = get_class($item);

        return $data;
    }
}

$formatter->addProcessor(new ClassNameProcessor());
```

The above example will output:

```
Array
(
    [count] => 42
    [class] => MeaningOfLifeCountable
)
```
