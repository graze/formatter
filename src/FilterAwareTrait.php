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
 * This trait provides an implementation for {@see Graze\Formatter\FilterAwareInterface}.
 *
 * @author Samuel Parkinson <sam@graze.com>
 */
trait FilterAwareTrait
{
    /**
     * @var callable[]
     */
    protected $filters = [];

    /**
     * @param callable $filter
     *
     * @return Graze\Formatter\FormatterInterface
     */
    public function addFilter(callable $filter)
    {
        array_unshift($this->filters, $filter);

        return $this;
    }
}
