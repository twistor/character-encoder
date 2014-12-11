<?php

/**
 * @file
 * Contains \CharacterEncoder\Tests\Utf8Test.
 */

namespace CharacterEncoder\Tests;

use CharacterEncoder\Userspace\Utf8;

/**
 */
class Utf8Test extends \PHPUnit_Framework_TestCase
{
    public function testReadResource()
    {
        $decoder = new Utf8();

        // Read the file.
        $string = file_get_contents(dirname(dirname(dirname(__FILE__))).'/test-resources/utf-8.txt');

        $this->assertTrue(mb_check_encoding($string, 'utf-8'));

        // Get the unicode stream.
        $stream = $decoder->decode($string, 'utf-8');

        $this->assertSame(mb_strlen($string, 'utf-8'), count($stream));

        // Re-encode the unicode stream.
        $encoded = $decoder->encode($stream, 'utf-8');
        $this->assertSame($string, $encoded);
    }
}
