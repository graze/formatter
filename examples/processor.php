<?php

require __DIR__ . '/../vendor/autoload.php';

class CountableFormatter extends \Graze\Formatter\AbstractFormatter
{
    protected function generate($item)
    {
        if (! $item instanceof Countable) {
            throw new \InvalidArgumentException(sprintf('`$item` must be an instance of %s.', Countable::class));
        }

        return [
            'count' => $item->count(),
        ];
    }
}

class MeaningOfLifeCountable implements Countable
{
    public function count()
    {
        return 42;
    }
}

$countable = new MeaningOfLifeCountable();
$formatter = new CountableFormatter();

// Create a processor ...
$processor = function (array $data, $item) {
    $data['class'] = get_class($item);

    return $data;
};

// ... and add it to the formatter.
$formatter->addProcessor($processor);

$result = $formatter->format($countable);

print_r($result);
