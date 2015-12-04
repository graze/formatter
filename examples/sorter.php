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
