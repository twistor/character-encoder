<?php

/**
 * @file
 * Contains \CharacterEncoder\Adapter\MbString.
 */

namespace CharacterEncoder\Adapter;

/**
 * Encoding adapter using the mbstring extension.
 */
class MbString implements Adapter
{
    /**
     * {@inheritdoc}
     */
    public function check($string, $encoding)
    {
        return (bool) @mb_check_encoding($string, $encoding);
    }

    /**
     * {@inheritdoc}
     */
    public function convert($string, $from, $to)
    {
        return (string) @mb_convert_encoding($string, $to, $from);
    }
}
