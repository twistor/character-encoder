<?php

/**
 * @file
 * Contains \CharacterEncoder\EncoderFactory.
 */

namespace CharacterEncoder;

/**
 * Factory used to detect the best encoder.
 */
class EncoderFactory
{
    /**
     * Returns the best encoder for the system.
     *
     * @param []string $encoding_list (optional) Encodings to search through.
     *
     * @return \CharacterEncoder\Encoder A character encoder.
     */
    public static function create(array $encoding_list = array())
    {
        if (extension_loaded('mbstring')) {
            $encoder = new MbEncoder();
        }
        // @codeCoverageIgnoreStart
        elseif (extension_loaded('iconv')) {
            $encoder = new IconvEncoder();
        } elseif (extension_loaded('recode')) {
            $encoder = new RecodeEncoder();
        } else {
            $encoder = new NoopEncoder();
        }
        // @codeCoverageIgnoreEnd

        $encoder->setEncodings($encoding_list);

        return $encoder;
    }
}
