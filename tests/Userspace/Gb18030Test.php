<?php

/**
 * @file
 * Contains \CharacterEncoder\Tests\Gb18030Test.
 */

namespace CharacterEncoder\Tests;

use CharacterEncoder\Userspace\Gb18030;

/**
 *
 */
class Gb18030Test extends \PHPUnit_Framework_TestCase
{
    public function testReadResource()
    {
        $decoder = new Gb18030();

        // Read the file.
        $string = file_get_contents(dirname(dirname(dirname(__FILE__))).'/test-resources/gb18030.txt');

        // Get the unicode stream.
        $stream = $decoder->decode($string, 'gb18030');

        $this->assertSame(mb_strlen($string, 'gb18030'), count($stream));

        // Re-encode the unicode stream.
        $encoded = $decoder->encode($stream, 'gb18030');
        $this->assertSame($string, $encoded);
    }
}
