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
    public function detect($string)
    {
        if ($detected = mb_detect_encoding($string, $this->getEncodings(), true)) {
            return $detected;
        }

        return mb_detect_encoding($string, $this->getEncodings());
    }

    /**
     * {@inheritdoc}
     */
    public function convert($string, $from, $to)
    {
        if (mb_check_encoding($string, $from)) {
            return mb_convert_encoding($string, $to, $from);
        }

        return false;
    }
}
