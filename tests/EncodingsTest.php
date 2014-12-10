<?php

/**
 * @file
 * Contains \CharacterEncoder\Tests\EncodingsTest.
 */

namespace CharacterEncoder\Tests;

use CharacterEncoder\Encodings;

/**
 * @covers \CharacterEncoder\Encodings
 */
class EncodingsTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $this->assertInternalType('array', Encodings::getCommonWebEncodings());
        $this->assertInternalType('array', Encodings::getUncommonWebEncodings());
    }
}
