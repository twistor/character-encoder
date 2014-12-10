<?php

/**
 * @file
 * Contains \CharacterEncoder\Tests\Adapter\NoopTest.
 */

namespace CharacterEncoder\Tests\Adapter;

use CharacterEncoder\Adapter\Noop;

/**
 * @covers \CharacterEncoder\Adapter\Noop
 */
class NoopTest extends AdapterTestBase
{
    /**
     * {@inheritdoc}
     */
    protected $adapterClass = 'CharacterEncoder\Adapter\Noop';

    /**
     * Tests encoding checking.
     *
     * @dataProvider textProvder
     */
    public function testCheck($string, $encoding)
    {
        $adapter = $this->newAdapter();
        $this->assertFalse($adapter->check($string, $encoding));
    }

    /**
     * Tests character conversion.
     *
     * @dataProvider textProvder
     */
    public function testConvert($string, $encoding)
    {
        $adapter = $this->newAdapter();

        $output = $adapter->convert($string, $encoding, 'utf-8');
        $this->assertSame('', $output);
    }
}
