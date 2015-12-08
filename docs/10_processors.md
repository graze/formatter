# Processors

Processors can be used to extend the functionality of a formatter.

## Using Anonymous Functions

```php
$processor = function (array $data, $item) {
    $data['class'] = get_class($item);

    return $data;
};

$formatter->addProcessor($processor);
```

## Using Graze\Formatter\AbstractProcessor

```php
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
