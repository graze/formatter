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
 * Describes a ...
 *
 * @author Samuel Parkinson <sam@graze.com>
 * @author Simon Lawrence <silawrenc@gmail.com>
 */
interface FormatterInterface
{
    /**
     * Format the given item into an array of data.
     *
     * @param mixed $item
     *
     * @return array
     */
    public function format($item);

    /**
     * Format the given items into an array of arrays.
     *
     * @param array $items
     *
     * @return array
     */
    public function formatMany(array $items);
}
