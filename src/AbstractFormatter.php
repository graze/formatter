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

use Graze\Sort;

/**
 * @author Samuel Parkinson <sam@graze.com>
 */
abstract class AbstractFormatter implements FormatterInterface
{
    use ProcessorCollectionTrait;

    use SorterCollectionTrait;

    /**
     * @param mixed $item
     *
     * @return array
     */
    public function format($item)
    {
        $data = $this->generate($item);

        return $this->handleProcessors($data, $item);
    }

    /**
     * @param array $items
     *
     * @return array
     */
    public function formatMany(array $items)
    {
        $formatted = array_map([$this, 'format'], $items);

        // @todo Handle filters.

        $sorted = $this->handleSorters($formatted);

        return $sorted;
    }

    /**
     * Convert `$item` into an formatted array of data.
     *
     * @param mixed $item
     *
     * @return array
     */
    abstract protected function generate($item);

    /**
     * Interate over each processor registered with the formatter and pass it
     * the aggregated data array and the item being formatted as arguments.
     *
     * @param array $data
     * @param mixed $item
     *
     * @return array
     */
    private function handleProcessors(array $data, $item)
    {
        // Callable that passes the procesor the correct arguments.
        $process = function(array $data, callable $processor) use ($item) {
            return $processor($data, $item);
        };

        return array_reduce($this->processors, $process, $data);
    }

    /**
     * @param $data
     *
     * @return array
     */
    private function handleSorters(array $data)
    {
        if ($this->sorters) {
            return Sort::schwartzian($data, $this->sorters);
        }

        return $data;
    }
}
