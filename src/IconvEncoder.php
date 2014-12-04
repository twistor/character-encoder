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
    public function detect($string)
    {
        foreach ($this->getEncodings() as $encoding) {
            if (@iconv($encoding, $encoding, $string) === $string) {
                return $encoding;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function convert($string, $from, $to)
    {
        return @iconv($from, $to, $string);
    }
}
