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

use Graze\Formatter\Processor\ProcessorAwareInterface;
use Graze\Formatter\Processor\ProcessorAwareTrait;

/**
 * A mock that uses the {@see ProcessorAwareTrait} trait.
 */
class MockProcessorAwareClass implements ProcessorAwareInterface
{
    use ProcessorAwareTrait;

    /**
     * @return array
     */
    public function getProcessors()
    {
        return $this->processors;
    }
}
