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

use Graze\Formatter\TraversableFormatterInterface;

class AbstractTraversableFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testFormatterImplementsInterfaces()
    {
        $formatter = new MockFormatter();

        assertThat($formatter, is(anInstanceOf(TraversableFormatterInterface::class)));
    }

    public function testShouldFormatTraversableAccordingToGenerateMethod()
    {
        $items = ['foo', 'bar', 'baz'];

        /** @var Generator **/
        $result = (new MockFormatter())->formatTraversable(new ArrayIterator($items));

        assertThat('The result of `formatTraversable` should be a Generator.',
            $result, is(anInstanceOf('Generator')));

        /** @var Generator **/
        $result = (new MockFormatter())->formatTraversable(new ArrayIterator($items));

        assertThat('Every item in the result should be an array.',
            iterator_to_array($result), everyItem(is(typeOf('array'))));

        /** @var Generator **/
        $result = (new MockFormatter())->formatTraversable(new ArrayIterator($items));

        assertThat('The result should be the same size as the number of items passed to `formatTraversable`.',
            $result, is(traversableWithSize(count($items))));

        /** @var Generator **/
        $result = (new MockFormatter())->formatTraversable(new ArrayIterator($items));

        assertThat('The result should be correctly formatted.',
            iterator_to_array($result), is(anArray([
                ['count' => 1],
                ['count' => 2],
                ['count' => 3],
            ])));
    }

    public function testFormatTraversableShouldApplyProcessors()
    {
        $items = ['foo', 'bar', 'baz'];

        $formatter = new MockFormatter();
        $formatter->addProcessor(function (array $data, $item) {
            $data[$item] = true;

            return $data;
        });

        $result = $formatter->formatTraversable(new ArrayIterator($items));

        $expected = [
            [
                'count' => 1,
                'foo' => true,
            ],
            [
                'count' => 2,
                'bar' => true,
            ],
            [
                'count' => 3,
                'baz' => true,
            ]
        ];

        assertThat('The formatter should correctly apply the processor.',
            iterator_to_array($result), is(anArray($expected)));
    }

    public function testFormatTraversableShouldApplyFilters()
    {
        $items = ['foo', 'bar', 'baz'];

        $formatter = new MockFormatter();
        $formatter->addFilter(function (array $data) {
            return $data['count'] !== 2;
        });

        $result = $formatter->formatTraversable(new ArrayIterator($items));

        assertThat('The formatter should correctly apply the filter.',
            iterator_to_array($result), is(arrayContaining(['count' => 1], ['count' => 3])));
    }
}
