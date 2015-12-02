<?php

class AbstractFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCallGenerateOnFormat()
    {
        $formatter = new MockFormatter();

        $result = $formatter->format('foo');

        assertThat('The result of `format` should be an array.',
            $result, is(typeOf('array')));

        assertThat('The result should match the mock response.',
            $result, is(anArray(['count' => 1])));
    }

    public function testShouldCallGenerateOnFormatMany()
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
}
