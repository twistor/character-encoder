<?php

/**
 * @file
 * Contains \CharacterEncoder\Adapter\Iconv.
 */

namespace CharacterEncoder\Adapter;

/**
 * Encoding adapter using the iconv extension.
 */
class Iconv implements Adapter
{
    /**
     * {@inheritdoc}
     */
    public function check($string, $encoding)
    {
        return @iconv($encoding, $encoding, $string) === $string;
    }

    /**
     * {@inheritdoc}
     */
    public function convert($string, $from, $to)
    {
        return (string) @iconv($from, $to, $string);
    }
}
