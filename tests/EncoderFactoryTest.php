<?php

/**
 * @file
 * Contains \CharacterEncoder\Tests\EncoderFactoryTest.
 */

namespace CharacterEncoder\Tests;

use CharacterEncoder\EncoderFactory;

/**
 * @covers \CharacterEncoder\EncoderFactory
 */
class EncoderFactoryTest extends \PHPUnit_Framework_TestCase {

  public function test() {
    $encoder = EncoderFactory::create(array());
  }

}
