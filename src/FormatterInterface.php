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
 * @author Simon Lawrence <silawrenc@gmail.com>
 */
interface FormatterInterface
{
    /**
     * @param callable $processor
     */
    public function addProcessor(callable $processor);

    /**
     * @param mixed $item
     */
    public function format($item);

    /**
     * @param array $items
     */
    public function formatMany(array $items);
}
