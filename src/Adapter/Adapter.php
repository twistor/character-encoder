<?php

/**
 * @file
 * Contains \CharacterEncoder\Adapter\Adapter.
 */

namespace CharacterEncoder\Adapter;

/**
 * Coverts character encodings via a specific mechanism.
 */
interface Adapter
{
    /**
     * Checks if a string is a specific encoding.
     *
     * @param string $string   The string to check.
     * @param string $encoding The encoding to check.
     *
     * @return bool True if the encoding is valid, false if not.
     */
    public function check($string, $encoding);

    /**
     * Converts a string from an encoding to another encoding.
     *
     * This doesn't do any verification of the encoding, so it's possible that
     * the out will be garbled text.
     *
     * @param string $string The string to convert.
     * @param string $from   The encoding of the string.
     * @param string $to     The desired encoding of the string.
     *
     * @return string The encoded string.
     */
    public function convert($string, $from, $to);
}
