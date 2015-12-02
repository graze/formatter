<?php

use Graze\Formatter\AbstractFormatter;

/**
 * A basic mock of a formatter that returns the number
 * of times `generate` has been called.
 */
class MockFormatter extends AbstractFormatter
{
    private $count = 0;

    protected function generate($item)
    {
        $this->count += 1;

        return [
            'count' => $this->count,
        ];
    }
}
