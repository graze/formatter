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

class AbstractFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testFormatterImplementsInterfaces()
    {
        $formatter = new MockFormatter();

        assertThat($formatter, is(anInstanceOf(FormatterInterface::class)));

        assertThat($formatter, is(anInstanceOf(FilterAwareInterface::class)));
        assertThat($formatter, is(anInstanceOf(ProcessorAwareInterface::class)));
        assertThat($formatter, is(anInstanceOf(SorterAwareInterface::class)));
    }

    public function testShouldFormatAccordingToGenerateMethod()
    {
        $formatter = new MockFormatter();

        $result = $formatter->format('foo');

        assertThat('The result of `format` should be an array.',
            $result, is(typeOf('array')));

        assertThat('The result should match the mock response.',
            $result, is(anArray(['count' => 1])));
    }

    public function testShouldFormatManyAccordingToGenerateMethod()
    {
        $items = ['foo', 'bar', 'baz'];

        $formatter = new MockFormatter();

        $result = $formatter->formatMany($items);

        assertThat('The result of `formatMany` should be an array of arrays.',
            $result, everyItem(is(typeOf('array'))));

        assertThat('The result should be the same size as the number of items passed to `formatMany`.',
            $result, is(arrayWithSize(count($items))));

        assertThat('The result should be correctly formatted.',
            $result, is(anArray([
                ['count' => 1],
                ['count' => 2],
                ['count' => 3],
            ])));
    }

    public function testFormatShouldApplyProcessors()
    {
        $formatter = new MockFormatter();
        $formatter->addProcessor(function (array $data) {
            $data['foo'] = true;

            return $data;
        });
        $formatter->addProcessor(function (array $data) {
            $data['bar'] = true;

            return $data;
        });

        $result = $formatter->format('foo');

        assertThat('The formatter should correctly apply the processors.',
            $result, is(anArray([
                'count' => 1,
                'foo' => true,
                'bar' => true,
            ])));
    }

    public function testFormatManyShouldApplyProcessors()
    {
        $items = ['foo', 'bar', 'baz'];

        $formatter = new MockFormatter();
        $formatter->addProcessor(function (array $data, $item) {
            $data[$item] = true;

            return $data;
        });

        $result = $formatter->formatMany($items);

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

        assertThat('The formatter should correctly apply the processors.',
            $result, is(anArray($expected)));
    }

    // Should handle filters.

    public function testFormatManyShouldApplySorters()
    {
        $items = ['foo', 'bar', 'baz'];

        $formatter = new MockFormatter();
        $formatter->addSorter(function (array $data) {
            // Reverse the order of the input.
            return -$data['count'];
        });

        $result = $formatter->formatMany($items);

        assertThat('The sorter should reverse the order of the formatted result.',
            $result, is(arrayContaining(['count' => 3], ['count' => 2], ['count' => 1])));
    }

    public function testFormatManyShouldApplySortersInOrder()
    {
        $items = ['foo', 'bar', 'baz'];

        $formatter = new MockFormatter();
        $formatter->addSorter(function (array $data) {
            // Reverse the order of the input.
            return -$data['count'];
        });
        $formatter->addSorter(function (array $data) {
            // Then reverse it back to the default.
            return $data['count'];
        });

        $result = $formatter->formatMany($items);

        assertThat('The sorter should apply sorters in the order they were added.',
            $result, is(arrayContaining(['count' => 1], ['count' => 2], ['count' => 3])));
    }
}
