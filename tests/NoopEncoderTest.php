<?php

/**
 * @file
 * Contains \CharacterEncoder\Tests\NoopEncoderTest.
 */

namespace CharacterEncoder\Tests;

use CharacterEncoder\NoopEncoder;

/**
 * @covers \CharacterEncoder\NoopEncoder
 */
class NoopEncoderTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $encoder = new NoopEncoder();
        $this->assertFalse($encoder->check('asdff', 'ascii'));
        $this->assertSame('', $encoder->convert('asdf', 'ascii', 'ascii'));
    }
}
