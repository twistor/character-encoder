<?php

/**
 * @file
 * Contains \CharacterEncoder\Tests\Adapter\IconvTest.
 */

namespace CharacterEncoder\Tests\Adapter;

use CharacterEncoder\Adapter\Iconv;

/**
 * @covers \CharacterEncoder\Adapter\Iconv
 */
class IconvTest extends AdapterTestBase
{
    /**
     * {@inheritdoc}
     */
    protected $adapterClass = 'CharacterEncoder\Adapter\Iconv';
}
