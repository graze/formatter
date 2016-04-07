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

namespace Graze\Formatter;

use Graze\Formatter\Filter;
use Graze\Formatter\FormatterInterface;
use Graze\Formatter\Processor;
use Graze\Formatter\Sorter;
use Graze\Formatter\TraversableFormatterInterface;
use Traversable;

/**
 * An abstract implmentation of the formatter interfaces.
 *
 * Extend this class and implement `convert` to get started with formatters.
 *
 * @author Samuel Parkinson <sam@graze.com>
 */
abstract class AbstractFormatter implements
    FormatterInterface,
    TraversableFormatterInterface,
    Processor\ProcessorAwareInterface,
    Sorter\SorterAwareInterface,
    Filter\FilterAwareInterface
{
    use Processor\ProcessorAwareTrait;

    use Sorter\SorterAwareTrait;

    use Filter\FilterAwareTrait;

    /**
     * Format the given object, applying all registered processors before returning the result.
     *
     * Each processor will get called with two arguments:
     *
     * * `$accumulator`, the result of calling `convert`, or the result of the previous processor
     * * `$object`, the argument that was passed to `format`
     *
     * Calls `convert` to initally convert `$object` into an array.
     *
     * @param mixed $object
     *
     * @return array
     */
    public function format($object)
    {
        /**
         * @var array
         */
        $accumulator = $this->convert($object);

        foreach ($this->processors as $processor) {
            $accumulator = $processor($accumulator, $object);
        }

        return $accumulator;
    }

    /**
     * Format an array of objects, applying all registered processors, sorters
     * and filters before returning the result.
     *
     * @param array $objects
     *
     * @return array
     */
    public function formatMany(array $objects)
    {
        $formatted = array_map([$this, 'format'], $objects);

        $filtered = $this->filter($formatted);

        return $this->sort($filtered);
    }

    /**
     * Format a Traversable group of objects, applying all registered processors
     * and filters before returning the result as a Generator.
     *
     * NOTE: This method doesn't apply any sorters to the result.
     *
     * @param Traversable $objects
     *
     * @return Generator
     */
    public function formatTraversable(Traversable $objects)
    {
        foreach ($objects as $object) {
            $formatted = $this->format($object);

            // Apply any registered filters, skipping this object if the filter does't return `true`.
            foreach ($this->filters as $filter) {
                if (! $filter($formatted)) {
                    continue 2;
                }
            }

            yield $formatted;
        }
    }

    /**
     * Convert the `$object` argument into a formatted array of data.
     *
     * @param mixed $object
     *
     * @return array
     */
    abstract protected function convert($object);

    /**
     * Interate over each filter registered with the formatter and remove
     * any matching elements.
     *
     * NOTE: `array_filter` will remove values when the callback doesn't return `true`.
     *
     * @param array $unfiltered
     *
     * @return array
     */
    private function filter(array $unfiltered)
    {
        if ($this->filters) {
            return array_reduce($this->filters, 'array_filter', $unfiltered);
        }

        return $unfiltered;
    }

    /**
     * Apply any registered sorters.
     *
     * @param array $unsorted
     *
     * @return array
     */
    private function sort(array $unsorted)
    {
        if ($this->sorters) {
            return \Graze\Sort\schwartzian($unsorted, $this->sorters);
        }

        return $unsorted;
    }
}
