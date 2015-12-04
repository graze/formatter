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
 * Tests for {@see \Graze\Formatter\SorterCollectionTrait} using the mock {@see MockSorterCollection}.
 */
class SorterCollectionTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testTraitShouldAddCallablesAsSorters()
    {
        $mock = new MockSorterCollection();

        $sorter = function () {
            return 0;
        };

        $mock->addSorter($sorter);

        assertThat('There should only be one sorter added.',
            $mock->getSorters(), is(arrayWithSize(1)));

        assertThat('The sorter should be the one we added.',
            reset($mock->getSorters()), is($sorter));
    }

    public function testTraitShouldAddSortersAsTheFirstSorterInTheCollection()
    {
        $mock = new MockSorterCollection();

        $sorterOne = function () {
            return 0;
        };

        $sorterTwo = function () {
            return 0;
        };

        $mock->addSorter($sorterOne);
        $mock->addSorter($sorterTwo);

        assertThat('The sorter should add sorters to the beginning of the collection.',
            $mock->getSorters(), is(arrayContaining($sorterTwo, $sorterOne)));
    }
}
