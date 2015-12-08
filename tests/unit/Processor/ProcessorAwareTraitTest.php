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

/**
 * Tests for {@see \Graze\Formatter\ProcessorAwareTrait} using the mock {@see MockProcessorAwareClass}.
 */
class ProcessorAwareTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testTraitShouldAddCallablesAsProcessors()
    {
        $mock = new MockProcessorAwareClass();

        $processor = function () {
            return [];
        };

        $mock->addProcessor($processor);

        assertThat('There should only be one processor added.',
            $mock->getProcessors(), is(arrayWithSize(1)));

        assertThat('The processor should be the one we added.',
            reset($mock->getProcessors()), is($processor));
    }
}
