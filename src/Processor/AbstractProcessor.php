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

namespace Graze\Formatter\Processor;

/**
 * Abstract class that can be passed to the `addProcessor` method
 * on an {@see Graze\Formatter\AbstractFormatter}.
 *
 * @author Samuel Parkinson <sam@graze.com>
 */
abstract class AbstractProcessor
{
    /**
     * Implemented to make the class callable. Calls the `process` method.
     *
     * @param array $data
     * @param mixed $item
     *
     * @return array
     */
    public function __invoke(array $data, $item)
    {
        return $this->process($data, $item);
    }

    /**
     * Method to modify the given array of data.
     *
     * This must return an array, typically the `$data` argument after modification.
     *
     * @param array $data
     * @param mixed $item
     *
     * @return array
     */
    abstract protected function process(array $data, $item);
}
