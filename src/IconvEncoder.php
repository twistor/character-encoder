<?php

/**
 * @file
 * Contains \CharacterEncoder\IconvEncoder.
 */

namespace CharacterEncoder;

/**
 * Character encoding using the iconv extension.
 */
class IconvEncoder extends EncoderBase
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
