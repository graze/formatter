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
 * This trait provides an implementation for the `addSorter` method defined in
 * {@see \Graze\Formatter\FormatterInterface}.
 *
 * @author Samuel Parkinson <sam@graze.com>
 */
trait SorterCollectionTrait
{
    /**
     * @var callable[]
     */
    protected $sorters = [];

    /**
     * @param callable $processor
     */
    public function addSorter(callable $sorter)
    {
        array_unshift($this->sorters, $sorter);
    }
}
