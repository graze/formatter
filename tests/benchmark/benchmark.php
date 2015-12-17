<?php

/**
 * This file is part of graze/formatter.
 *
 * Copyright (c) 2015 Nature Delivered Ltd. <https://www.graze.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://github.com/graze/formatter/blob/master/LICENSE MIT
 */

require __DIR__ . '/../../vendor/autoload.php';

echo PHP_EOL . 'Benchmarking `Graze\Formatter\AbstractFormatter::formatMany()`.' . PHP_EOL . PHP_EOL;

class CountableFormatter extends \Graze\Formatter\AbstractFormatter
{
    protected function convert($object)
    {
        return ['count' => $object->count()];
    }
}

$processor = function (array $data, Countable $object) {
    return $data;
};

$filter = function (array $data) {
    return true;
};

$sorter = function (array $data) {
    return 0;
};

class BenchmarkCountable implements Countable
{
    private $count = 0;

    public function count()
    {
        return $this->count += 1;
    }
}

$benchmark = function ($formatter) {
    $results = [];

    foreach(range(0, 5) as $i) {
        $start = microtime(true);

        $countable = new BenchmarkCountable();
        $countables = [];

        for ($i = 0; $i < 100000; $i++) {
            $countables[] = $countable;
        }

        $formatter->formatMany($countables);

        $end = microtime(true);
        $results[] = $end - $start;

        echo '.';
    }

    unset($start, $end, $formatter, $countable, $countables);

    return (array_sum($results) / count($results)) * 1000;
};

$formatter = new CountableFormatter();

echo sprintf(' Formatting took on average %d ms.' . PHP_EOL, $benchmark($formatter));

$formatter = new CountableFormatter();
$formatter->addProcessor($processor);

echo sprintf(' Formatting with a processor took on average %d ms.' . PHP_EOL, $benchmark($formatter));

$formatter = new CountableFormatter();
$formatter->addFilter($filter);

echo sprintf(' Formatting with a filter took on average %d ms.' . PHP_EOL, $benchmark($formatter));

$formatter = new CountableFormatter();
$formatter->addSorter($sorter);

echo sprintf(' Formatting with a sorter took on average %d ms.' . PHP_EOL, $benchmark($formatter));
