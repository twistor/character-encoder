<?php

/**
 * @file
 * Contains \CharacterEncoder\Tests\Adapter\AdapterTestBase.
 */

namespace CharacterEncoder\Tests\Adapter;

/**
 * @covers \CharacterEncoder\Adapter\MbString
 */
abstract class AdapterTestBase extends \PHPUnit_Framework_TestCase
{
    /**
     * The encodings to test.
     *
     * @var []string
     */
    protected $testEncodings = array('EUC-JP', 'CP866');

    /**
     * The adapter class to test.
     *
     * @var string
     */
    protected $adapterClass;

    /**
     * Tests encoding checking.
     *
     * @dataProvider textProvder
     */
    public function testCheck($string, $encoding)
    {
        $adapter = $this->newAdapter();
        $this->assertTrue($adapter->check($string, $encoding));
    }

    /**
     * Tests character conversion.
     *
     * @dataProvider textProvder
     */
    public function testConvert($string, $encoding)
    {
        $adapter = $this->newAdapter();

        $expected = mb_convert_encoding($string, 'utf-8', $encoding);
        $output = $adapter->convert($string, $encoding, 'utf-8');
        $this->assertSame($expected, $output);
    }

    /**
     * Provides encoded strings.
     *
     * @return array An array($string, $encoding)
     */
    public function textProvder()
    {
        $prefix = dirname(__FILE__).'/../../test-resources/';

        $return = array();
        foreach ($this->testEncodings as $encoding) {
            $string = file_get_contents($prefix.strtolower($encoding).'.txt');
            $return[] = array($string, $encoding);
        }

        return $return;
    }

    /**
     * Returns a new adapter.
     *
     * @return \CharacterEncoder\Adapter\Adapter A new adapter.
     */
    protected function newAdapter()
    {
        $class = $this->adapterClass;
        return new $class();
    }
}
