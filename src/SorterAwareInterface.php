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
interface SorterAwareInterface
{
    /**
     * @param callable $sorter
     */
    public function addSorter(callable $sorter);
}
