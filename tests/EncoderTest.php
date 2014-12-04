<?php

/**
 * @file
 * Contains \CharacterEncoder\Tests\EncoderTest.
 */

namespace CharacterEncoder\Tests;

/**
 * Base class for encoders.
 *
 * Each encoder is an instance of this class ensuring that the behavior is the
 * same for each encoder.
 */
abstract class EncoderTest extends \PHPUnit_Framework_TestCase {

  /**
   * Returns a new encoder.
   */
  protected function newEncoder() {
    $class = $this->encoderClass;
    return new $class();
  }

  /**
   * @dataProvider textProvder
   */
  public function testsDetect($string, $encoding) {
    $encoder = $this->newEncoder();
    $encoder->setEncodings(array('UTF-8', 'EUC-JP', 'CP866'));
    $this->assertEquals($encoding, $encoder->detectEncoding($string));
  }

  /**
   * @dataProvider textProvder
   */
  public function testsEncodingNotFound($string, $encoding) {
    $encoder = $this->newEncoder();
    $encoder->setEncodings(array('ascii'));
    $this->assertEquals(FALSE, $encoder->detectEncoding($string));
  }

  /**
   * @dataProvider textProvder
   */
  public function testConvert($string, $encoding) {
    $encoder = $this->newEncoder();
    $expected = mb_convert_encoding($string, 'utf-8', $encoding);
    $this->assertEquals($expected, $encoder->convertEncoding($string, $encoding, 'utf-8'));
  }

  /**
   * @covers \CharacterEncoder\EncoderBase
   * @dataProvider textProvder
   */
  public function testConvertToUtf8($string, $encoding) {
    $encoder = $this->newEncoder();
    $encoder->setEncodings(array('UTF-8', 'ascii', 'EUC-JP'));

    $this->assertSame(array('UTF-8', 'ascii', 'EUC-JP'), $encoder->getEncodings());

    $content = file_get_contents(dirname(__FILE__) . '/../test-resources/euc-jp.txt');
    $this->assertSame(mb_convert_encoding($content, 'utf-8', 'EUC-JP'), $encoder->convertToUtf8($content));

    $content = file_get_contents(dirname(__FILE__) . '/../test-resources/cp866.txt');
    $this->assertFalse($encoder->convertToUtf8($content));
  }

  /**
   * Text content provider.
   */
  public function textProvder() {
    $files = array('EUC-JP', 'CP866');

    $prefix = dirname(__FILE__) . '/../test-resources/';

    $return = array();
    foreach ($files as $encoding) {
      $content = file_get_contents($prefix . strtolower($encoding) . '.txt');
      $return[] = array($content, $encoding);
    }

    return $return;
  }

}
