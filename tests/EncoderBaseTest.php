<?php

/**
 * @file
 * Contains \CharacterEncoder\Tests\EncoderBaseTest.
 */

namespace CharacterEncoder\Tests;

use CharacterEncoder\MbEncoder;

/**
 * @covers \CharacterEncoder\EncoderBase
 */
class EncoderBaseTest extends \PHPUnit_Framework_TestCase {

  public function test() {
    // Use MbEncoder to test the base methods.
    $encoder = new MbEncoder();
    $encoder->setEncodings(array('UTF-8', 'ascii'));

    $this->assertSame(array('UTF-8', 'ascii'), $encoder->getEncodings());

    $content = file_get_contents(dirname(__FILE__) . '/../test-resources/euc-jp.txt');
    $this->assertSame(mb_convert_encoding($content, 'utf-8', 'EUC-JP'), $encoder->convertToUtf8($content, 'EUC-JP'));
  }

}
