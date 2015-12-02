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

/**
 * @author Samuel Parkinson <sam@graze.com>
 */
abstract class AbstractFormatter implements FormatterInterface
{
    use ProcessorCollectionTrait;

    /**
     * Convert `$item` into an formatted array of data.
     *
     * @param mixed $item
     *
     * @return array
     */
    abstract public function generate($item);

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
        // Return the result of calling `format` on each item.
        return array_map([$this, 'format'], $items);
    }

    /**
     * Interate over each processor registered with the formatter and pass it
     * the data array and the item being formatted as arguments. Returning the
     * resulting data array after all the processors have done their work.
     *
     * @param array $data
     * @param mixed $item
     *
     * @return array
     */
    protected function handleProcessors(array $data, $item)
    {
        // Callable that passes the procesor the correct arguments.
        $process = function(array $data, callable $processor) use ($item) {
            return $processor($data, $item);
        };

        return array_reduce($this->processors, $process, $data);
    }
}
