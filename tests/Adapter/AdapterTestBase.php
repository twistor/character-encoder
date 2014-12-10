<?php

/**
 * @file
 * Contains \CharacterEncoder\Tests\Adapter\AdapterTestBase.
 */

namespace CharacterEncoder\Tests\Adapter;

/**
 * Each encoder uses the same test class to ensure behavior is consistent.
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
     * Tests that invalid endodings don't give an error.
     */
    public function testCheckInvalid()
    {
        $adapter = $this->newAdapter();
        $this->assertSame(false, $adapter->check('abcd', 'INVALID'));
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
     * Tests that invalid endodings don't give an error.
     */
    public function testCheckConvert()
    {
        $adapter = $this->newAdapter();
        $this->assertSame('', $adapter->convert('abcd', 'INVALID', 'INVALID'));
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
