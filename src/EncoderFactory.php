<?php

/**
 * @file
 * Contains \CharacterEncoder\EncoderFactory.
 */

namespace CharacterEncoder;

use CharacterEncoder\Adapter\Iconv;
use CharacterEncoder\Adapter\MbString;
use CharacterEncoder\Adapter\Noop;
use CharacterEncoder\Adapter\Recode;

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
            $adapter = new MbString();
        }
        // @codeCoverageIgnoreStart
        elseif (extension_loaded('iconv')) {
            $adapter = new Iconv();
        } elseif (extension_loaded('recode')) {
            $adapter = new Recode();
        } else {
            $adapter = new Noop();
        }
        // @codeCoverageIgnoreEnd

        $encoder = new Encoder($adapter);
        $encoder->setEncodings($encoding_list);

        return $encoder;
    }
}
