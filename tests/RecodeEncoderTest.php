<?php

/**
 * @file
 * Contains \CharacterEncoder\Tests\RecodeEncoderTest.
 */

namespace CharacterEncoder\Tests;

use CharacterEncoder\RecodeEncoder;

// Have to figure out how to get recode installed on travis.
if (extension_loaded('recode')) {
    /**
     * @covers \CharacterEncoder\RecodeEncoder
     */
    class RecodeEncoderTest extends EncoderTest
    {
        protected $encoderClass = 'CharacterEncoder\RecodeEncoder';
    }
}
