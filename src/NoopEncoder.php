<?php

/**
 * @file
 * Contains \CharacterEncoder\NoopEncoder.
 */

namespace CharacterEncoder;

/**
 * Stub character converter thas does nothing.
 */
class NoopEncoder extends EncoderBase
{
    /**
     * {@inheritdoc}
     */
    public function detectEncoding($string)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function convert($string, $from, $to)
    {
        return false;
    }
}
