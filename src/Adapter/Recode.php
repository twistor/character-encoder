<?php

/**
 * @file
 * Contains \CharacterEncoder\Adapter\Recode.
 */

namespace CharacterEncoder\Adapter;

/**
 * Encoding adapter using the recode extension.
 */
class Recode implements Adapter
{
    /**
     * {@inheritdoc}
     */
    public function check($string, $encoding)
    {
        // recode_string() from..to the same encoding is a noop, so we have
        // to do this dance.
        $to = strtolower($encoding) !== 'utf-8' ? 'utf-8' : 'utf-16';

        // Reuse the same variable to attempt to keep the memory usage down.
        $encoded = @recode_string($encoding.'..'.$to, $string);
        $encoded = @recode_string($to.'..'.$encoding, $encoded);

        return $encoded === $string;
    }

    /**
     * {@inheritdoc}
     */
    public function convert($string, $from, $to)
    {
        return (string) @recode_string($from.'..'.$to, $string);
    }
}
