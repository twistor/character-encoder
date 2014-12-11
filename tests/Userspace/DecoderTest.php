<?php

/**
 * @file
 * Contains \CharacterEncoder\Tests\DecoderTest.
 */

namespace CharacterEncoder\Tests;

use CharacterEncoder\Userspace\SingleByteDecoder;
use CharacterEncoder\Userspace\Utf8;

/**
 */
class DecoderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider encodingProvider
     */
    public function testReadResource($encoding) {
        $decoder = new SingleByteDecoder();

        // Read the file.
        $string = file_get_contents(dirname(dirname(dirname(__FILE__))).'/test-resources/'.$encoding.'.txt');

        // Get the unicode stream.
        $stream = $decoder->decode($string, $encoding);

        $utf8 = mb_convert_encoding($string, 'utf-8', $encoding);

        $this->assertSame($utf8, (new Utf8())->encode($stream));

        // Re-encode the unicode stream.
        $encoded = $decoder->encode($stream, $encoding);
        $this->assertSame($string, $encoded);
    }

    public function encodingProvider()
    {
        return array(
            array('ibm866'),
            array('koi8-r'),
        );
    }
}
