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

use Graze\Formatter\AbstractFormatter;

/**
 * A mock of a formatter that returns the number of times `generate` has been called.
 */
class MockFormatter extends AbstractFormatter
{
    private $count = 0;

    protected function convert($item)
    {
        $this->count += 1;

        return [
            'count' => $this->count,
        ];
    }
}
