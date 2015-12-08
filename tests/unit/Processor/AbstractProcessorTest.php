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

class AbstractProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldBeCallableThatCallsProcessMethod()
    {
        $processor = new MockProcessor();

        assertThat('The processor is a callable.',
            $processor, is(callableValue()));

        $result = $processor(['foo' => 'bar'], 'foo');

        // The mock processor just returns the input data array.
        assertThat('The result of processor should be the same as the input.',
            $result, is(anArray(['foo' => 'bar'])));

        assertThat('The processor should be able to make use of the item being formatted.',
            $processor->getLatestItem(), is('foo'));
    }
}
