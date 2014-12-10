<?php

/**
 * @file
 * Contains \CharacterEncoder\Tests\EncoderTest.
 */

namespace CharacterEncoder\Tests;

use CharacterEncoder\Adapter\MbString;
use CharacterEncoder\Adapter\Noop;
use CharacterEncoder\Encoder;

/**
 * @covers \CharacterEncoder\Encoder
 */
class EncoderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetEncodings()
    {
        $encoder = new Encoder(new Noop());
        $encodings = array('abcd');
        $encoder->setEncodings($encodings);
        $this->assertSame($encodings, $encoder->getEncodings());
    }

    public function testCheckString()
    {
        $encoder = new Encoder(new MbString());
        $this->assertTrue($encoder->checkString('abcd', 'utf-8'));
    }

    public function testDetectString()
    {
        $encoder = new Encoder(new MbString());
        $encoder->setEncodings(array('utf-8'));
        $this->assertSame('utf-8', $encoder->detectString('abcd'));

        // Content-Type should be detected first.
        $this->assertSame('ascii', $encoder->detectString('abcd', 'text/html; charset=ascii'));

        // Content-Type should fail.
        $this->assertSame('utf-8', $encoder->detectString('abcd', 'text/html; charset=beep'));

        // Completely invalid Content-Type header.
        $this->assertSame('utf-8', $encoder->detectString('abcd', '1111'));

        // All detection should fail.
        $string = file_get_contents(dirname(__FILE__).'/../test-resources/euc-jp.txt');
        $this->assertFalse($encoder->detectString($string));
    }

    public function testConvertString()
    {
        $encoder = new Encoder(new MbString());
        $encoder->setEncodings(array('utf-8'));
        $this->assertSame('abcd', $encoder->convertString('abcd', 'utf-8', 'euc-jp'));
    }

    public function testCheckStream()
    {
        $encoder = new Encoder(new MbString());

        $stream = fopen('php://memory', 'rw');
        fwrite($stream, 'abcd');
        $this->assertSame(true, $encoder->checkStream($stream, 'utf-8'));
        $this->assertSame(0, ftell($stream));

        // Check stream with BOM.
        fwrite($stream, "\xEF\xBB\xBF".'abcd');
        $this->assertSame(true, $encoder->checkStream($stream, 'utf-8'));
        // Check that
        fclose($stream);
    }

    public function testDetectStream()
    {
        $encoder = new Encoder(new MbString());
        $encoder->setEncodings(array('ascii'));

        $stream = fopen('php://memory', 'rw');
        fwrite($stream, 'abcd');
        $this->assertSame('ascii', $encoder->detectStream($stream));
        $this->assertSame(0, ftell($stream));

        // Check stream with BOM.
        $stream = fopen('php://memory', 'rw');
        fwrite($stream, "\xEF\xBB\xBF".'abcd');
        $this->assertSame('UTF-8', $encoder->detectStream($stream));

        // Check that Content-Type gets checked before BOM and list, but the
        // BOM is still read.
        $this->assertSame('ISO-8859-1', $encoder->detectStream($stream, 524288, 'text/html; charset=ISO-8859-1'));
        $this->assertSame('UTF-8', $encoder->detectStream($stream, 524288, 'text/html; charset=UTF-32BE'));

        // Test invalid BOM.
        fwrite($stream, "\x00\x00\xFE\xFF".'abcd');
        $this->assertSame('ascii', $encoder->detectStream($stream));

        fclose($stream);
    }

    public function testConvertStream()
    {
        $encoder = new Encoder(new MbString());
        $stream = fopen('php://memory', 'rw');
        fwrite($stream, 'abcd');

        $converted = $encoder->convertStream($stream, 'ascii', 'UTF-32BE');
        $converted_string = stream_get_contents($converted);
        $this->assertSame(mb_convert_encoding('abcd', 'UTF-32BE', 'ascii'), $converted_string);

        fclose($stream);
        fclose($converted);
    }
}
