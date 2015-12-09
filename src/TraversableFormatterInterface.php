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

use Traversable;

/**
 * Describes a traversable formatter.
 *
 * @author Samuel Parkinson <sam@graze.com>
 */
interface TraversableFormatterInterface
{
    /**
     * Format the given Traversable of objects into a Traversable of data.
     *
     * @param Traversable $objects
     *
     * @return Traversable
     */
    public function formatTraversable(Traversable $objects);
}
