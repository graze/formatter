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

use function Graze\Sort\schwartzian;
use Graze\Formatter\Filter;
use Graze\Formatter\FormatterInterface;
use Graze\Formatter\Processor;
use Graze\Formatter\Sorter;

/**
 * @author Samuel Parkinson <sam@graze.com>
 */
abstract class AbstractFormatter implements
    FormatterInterface,
    Processor\ProcessorAwareInterface,
    Sorter\SorterAwareInterface,
    Filter\FilterAwareInterface
{
    use Processor\ProcessorAwareTrait;

    use Sorter\SorterAwareTrait;

    use Filter\FilterAwareTrait;

    /**
     * Format the given item, applying all registered processors before returning the result.
     *
     * Each processor will get called with two arguments:
     *
     * * `$data`, the result of calling `generate`
     * * `$object`, the argument that was passed to `generate`
     *
     * Calls `generate` to initally convert `$object` into an array.
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
        $formatted = $this->generate($object);

        if ($this->processors) {
            // Callable that passes the processor the correct arguments.
            $process = function(array $data, callable $processor) use ($object) {
                return $processor($data, $object);
            };

            // Call each processor with the formatted object.
            return array_reduce($this->processors, $process, $formatted);
        }

        return $formatted;
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
     * Convert the `$object` argument into a formatted array of data.
     *
     * @param mixed $object
     *
     * @return array
     */
    abstract protected function generate($object);

    /**
     * Interate over each filter registered with the formatter and remove
     * any matching elements.
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
            return schwartzian($unsorted, $this->sorters);
        }

        return $unsorted;
    }
}
