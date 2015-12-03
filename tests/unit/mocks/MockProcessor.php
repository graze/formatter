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

use Graze\Formatter\AbstractProcessor;

/**
 * A mock of a processor.
 */
class MockProcessor extends AbstractProcessor
{
    /**
     * @var mixed
     */
    private $latestItem;

    /**
     * @param array $data
     * @param mixed $item
     *
     * @return array
     */
    protected function process(array $data, $item)
    {
        $this->latestItem = $item;

        return $data;
    }

    /**
     * @return mixed
     */
    public function getLatestItem()
    {
        return $this->latestItem;
    }
}
