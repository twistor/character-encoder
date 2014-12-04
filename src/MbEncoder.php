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
    public function detectEncoding($string)
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
        return mb_convert_encoding($string, $to, $from);
    }
}
