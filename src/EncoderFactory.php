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
        $encoder = new Encoder(static::getAdapter());
        $encoder->setEncodings($encoding_list);

        return $encoder;
    }

    /**
     * Returns the best encoder for the system.
     *
     * @param \CharacterEncoder\Encoder $encoder An optional encoder to use.
     *
     * @return \CharacterEncoder\Encoder A character encoder.
     */
    public static function createXmlEncoder(Encoder $encoder = null)
    {
        if (!$encoder) {
            $encoder = static::create();
        }

        return new XmlEncoder();
    }

    /**
     * Returns the adapter based on the environment.
     *
     * @return \CharacterEncoder\Adapter\Adapter A new adapter.
     */
    protected static function getAdapter()
    {
        if (extension_loaded('mbstring')) {
            return new MbString();
        }
        // @codeCoverageIgnoreStart
        elseif (extension_loaded('iconv')) {
            return new Iconv();
        } elseif (extension_loaded('recode')) {
            return new Recode();
        } else {
            return new Noop();
        }
        // @codeCoverageIgnoreEnd
    }
}
