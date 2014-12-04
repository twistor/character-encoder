<?php

/**
 * @file
 * Contains \CharacterEncoder\Tests\EncoderTest.
 */

namespace CharacterEncoder\Tests;

/**
 * Base class for encoders.
 *
 * Each encoder test is an instance of this class ensuring that the behavior is
 * the same for every encoder.
 */
abstract class EncoderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The encodings to test.
     *
     * @var []string
     */
    protected $testEncodings = array('EUC-JP', 'CP866');

    /**
     * Returns a new encoder.
     *
     * Subclasses set self::$encoderClass to their class.
     *
     * @return \CharacterEncoder\Encoder
     */
    protected function newEncoder()
    {
        $class = $this->encoderClass;
        return new $class();
    }

    /**
     * Tests encoding detection.
     *
     * @dataProvider textProvder
     */
    public function testsDetect($string, $encoding)
    {
        $encoder = $this->newEncoder();
        $encoder->setEncodings(array('UTF-8', 'EUC-JP', 'CP866'));
        $this->assertEquals($encoding, $encoder->detect($string));
    }

    /**
     * Tests invalid encoding detection.
     *
     * @dataProvider textProvder
     */
    public function testsEncodingNotFound($string, $encoding)
    {
        $encoder = $this->newEncoder();
        $encoder->setEncodings(array('ascii'));
        $this->assertFalse($encoder->detect($string));
    }

    /**
     * Tests encoding conversion.
     *
     * @dataProvider textProvder
     */
    public function testConvert($string, $encoding)
    {
        $encoder = $this->newEncoder();
        $expected = mb_convert_encoding($string, 'utf-8', $encoding);
        $this->assertEquals($expected, $encoder->convert($string, $encoding, 'utf-8'));
    }

    /**
     * Tests automatic utf-8 conversion.
     *
     * @covers \CharacterEncoder\EncoderBase
     * @dataProvider textProvder
     */
    public function testConvertToUtf8($string, $encoding)
    {
        $encoder = $this->newEncoder();
        $encoder->setEncodings(array('UTF-8', 'ascii', 'EUC-JP'));

        $this->assertSame(array('UTF-8', 'ascii', 'EUC-JP'), $encoder->getEncodings());

        $content = file_get_contents(dirname(__FILE__).'/../test-resources/euc-jp.txt');
        $this->assertSame(mb_convert_encoding($content, 'utf-8', 'EUC-JP'), $encoder->toUtf8($content));

        $content = file_get_contents(dirname(__FILE__).'/../test-resources/cp866.txt');
        $this->assertFalse($encoder->toUtf8($content));
    }

    /**
     * Tests the quick utf-8 conversion method.
     *
     * @covers \CharacterEncoder\EncoderBase
     */
    public function testCompatible()
    {
        $encoder = $this->newEncoder();
        $encoder->setEncodings(array('ascii'));

        $content = file_get_contents(dirname(__FILE__).'/../test-resources/ascii.txt');
        $this->assertSame($content, $encoder->toUtf8($content));
    }

    /**
     * Provides encoded strings.
     *
     * @return array An array($content, $encoding)
     */
    public function textProvder()
    {
        $prefix = dirname(__FILE__).'/../test-resources/';

        $return = array();
        foreach ($this->testEncodings as $encoding) {
            $content = file_get_contents($prefix.strtolower($encoding).'.txt');
            $return[] = array($content, $encoding);
        }

        return $return;
    }
}
