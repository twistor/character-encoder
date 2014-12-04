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
        $this->assertFalse($encoder->detect('asdff'));
        $this->assertSame(false, $encoder->convert('asdf', 'ascii', 'ascii'));
    }
}
