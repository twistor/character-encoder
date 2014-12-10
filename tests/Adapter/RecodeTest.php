<?php

/**
 * @file
 * Contains \CharacterEncoder\Tests\Adapter\RecodeTest.
 */

namespace CharacterEncoder\Tests\Adapter;

use CharacterEncoder\Adapter\Recode;

/**
 * @covers \CharacterEncoder\Adapter\Recode
 */
class RecodeTest extends AdapterTestBase
{
    /**
     * {@inheritdoc}
     */
    protected $adapterClass = 'CharacterEncoder\Adapter\Recode';

    /**
     * Tests encoding checking.
     *
     * @dataProvider textProvder
     */
    public function testCheck($string, $encoding)
    {
        if (extension_loaded('recode')) {
            parent::testCheck($string, $encoding);
        }
    }

    /**
     * Tests character conversion.
     *
     * @dataProvider textProvder
     */
    public function testConvert($string, $encoding)
    {
        if (extension_loaded('recode')) {
            parent::testConvert($string, $encoding);
        }
    }
}
