<?php

/**
 * @file
 * Contains \CharacterEncoder\MbEncoder.
 */

namespace CharacterEncoder;

/**
 * Character encoding using the mbstring extension.
 */
class MbEncoder extends EncoderBase
{
    /**
     * {@inheritdoc}
     */
    public function check($string, $encoding) {
        return mb_check_encoding($string, $encoding);
    }

    /**
     * {@inheritdoc}
     */
    public function convert($string, $from, $to)
    {
        return mb_convert_encoding($string, $to, $from);
    }
}
