<?php

/**
 * @file
 * Contains \CharacterEncoder\Encoder.
 */

namespace CharacterEncoder;

/**
 * Coverts character encodings.
 */
interface Encoder {

  /**
   * Returns the current list of encodings being checked.
   *
   * @return []string
   *   A list of character encodings.
   */
  public function getEncodings();

  /**
   * Sets the list of character encodings to check.
   *
   * @param array $encodings
   *   A list of character encodings.
   */
  public function setEncodings(array $encodings);

  /**
   * Detects the encoding of a given string.
   *
   * @param string $string
   *   The string to detect the encoding of.
   *
   * @return string|bool
   *   The detected character encoding, or false if it couldn't be determined.
   */
  public function detectEncoding($string);

  /**
   * Converts a string from an encoding to an encoding.
   *
   * @param string $string
   *   The string to convert.
   * @param string $from
   *   The encoding of the string.
   * @param string $to
   *   The desired encoding of the string.
   *
   * @return string|bool
   *   The encoded string, or false if the conversion failed.
   */
  public function convert($string, $from, $to);

  /**
   * Converts a string to utf-8.
   *
   * @param string $string
   *   The string to convert.
   *
   * @return string|bool
   *   The encoded string, or false if the conversion failed.
   */
  public function toUtf8($string);

}
