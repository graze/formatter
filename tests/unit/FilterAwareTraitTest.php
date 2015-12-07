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
 * Tests for {@see \Graze\Formatter\FilterAwareTrait} using the mock {@see MockFilterAwareClass}.
 */
class FilterAwareTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testTraitShouldAddCallablesAsFilters()
    {
        $mock = new MockFilterAwareClass();

        $filter = function (array $data) {
            return 0;
        };

        $mock->addFilter($filter);

        assertThat('There should only be one filter added.',
            $mock->getFilters(), is(arrayWithSize(1)));

        assertThat('The filter should be the one we added.',
            reset($mock->getFilters()), is($filter));
    }
}
