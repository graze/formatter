# Processors

Processors can be used to extend the functionality of a formatter.

## Using Anonymous Functions

```php
$processor = function (array $data, $object) {
    $data['class'] = get_class($object);

    return $data;
};

$formatter->addProcessor($processor);
```

## Using `AbstractProcessor`

```php
use Graze\Formatter\Processor\AbstractProcessor;

final class ClassNameProcessor extends AbstractProcessor
{
    protected function process(array $data, $object)
    {
        $data['class'] = get_class($object);

        return $data;
    }
}

$formatter->addProcessor(new ClassNameProcessor());
```
