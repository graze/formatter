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
 * This trait provides an implementation for the `addProcessor` method defined in
 * {@see \Graze\Formatter\FormatterInterface}.
 *
 * @author Samuel Parkinson <sam@graze.com>
 */
trait ProcessorCollectionTrait
{
    /**
     * @var callable[]
     */
    protected $processors = [];

    /**
     * @param callable $processor
     */
    public function addProcessor(callable $processor)
    {
        $this->processors[] = $processor;
    }
}
