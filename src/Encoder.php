<?php

/**
 * @file
 * Contains \CharacterEncoder\Encoder.
 */

namespace CharacterEncoder;

/**
 * Coverts character encodings.
 */
interface Encoder
{
    /**
     * Returns the current list of encodings being checked.
     *
     * @return []string A list of character encodings.
     */
    public function getEncodings();

    /**
     * Sets the list of character encodings to check.
     *
     * @param []string $encodings A list of character encodings.
     */
    public function setEncodings(array $encodings);

    /**
     * Detects the encoding of a given string.
     *
     * @param string $string The string to detect the encoding of.
     *
     * @return string|bool The detected character encoding, or false if it couldn't be determined.
     */
    public function detect($string);

    /**
     * Detects the encoding of a file.
     *
     * @param resource $handle A file handle.
     * @param int      $length The length of file to read in bytes. Defaults to 0.5MB.
     *
     * @return string|bool The detected character encoding, or false if it couldn't be determined.
     */
    public function detectFile($handle, $length = 524288);

    /**
     * Checks that a string is a valid encoding.
     *
     * @param string $string   The string to check.
     * @param string $encoding The encoding to check.
     *
     * @return bool True if the encoding is valid, false if not.
     */
    public function check($string, $encoding);

    /**
     * Converts a string from an encoding to an encoding.
     *
     * This doesn't do any verification of the encoding, so it's possible that
     * the out will be garbled text. Use Encoder::detect() or Encoder::check()
     * to verify an encoding.
     *
     * @param string $string The string to convert.
     * @param string $from   The encoding of the string.
     * @param string $to     The desired encoding of the string.
     *
     * @return string The encoded string.
     */
    public function convert($string, $from, $to);

    /**
     * Converts a file from one encoding to another.
     *
     * This returns a php://temp stream. To overwrite the existing file:
     * @code
     * $tmp = $encoder->convertFile($handle, $from, $to);
     * ftruncate($handle, 0);
     * stream_copy_to_stream($tmp, $handle);
     * fclose($tmp);
     * @endcode
     *
     *
     * @param resource $handle A file handle.
     * @param string   $from   The encoding of the string.
     * @param string   $to     The desired encoding of the string.
     *
     * @return resource A new file handle with the encoded text.
     */
    public function convertFile($handle, $from, $to);

    /**
     * Converts a string to utf-8.
     *
     * @param string $string The string to convert.
     *
     * @return string|bool The encoded string, or false if the conversion failed.
     */
    public function toUtf8($string);
}
