# Formatters

A formatter is a class that takes one or more objects and converts them into an array of data.

Formatters should be _very_ reusable classes. To add more specific keys to the result, use a [processor](01-processors.md).

We use this pattern at graze to ensure we're only passing what we need to our twig templates.

## Usage

```php
use Graze\Formatter\AbstractFormatter;

class CountableFormatter extends AbstractFormatter
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
```
