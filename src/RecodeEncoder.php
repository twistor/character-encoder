<?php

/**
 * @file
 * Contains \CharacterEncoder\RecodeEncoder.
 */

namespace CharacterEncoder;

/**
 * Character encoding using the recode extension.
 */
class RecodeEncoder extends EncoderBase {

  /**
   * {@inheritdoc}
   */
  public function detectEncoding($string) {
    foreach ($this->getEncodings() as $encoding) {
      // recode_string() from..to the same encoding is a noop, so we have to do
      // this dance.
      $to = strtolower($encoding) === 'utf-8' ? 'utf-16' : 'utf-8';

      $encoded = recode_string($encoding . '..' . $to, $string);
      $decoded = recode_string($to . '..' . $encoding, $encoded);
      if ($decoded === $string) {
        return $encoding;
      }
    }

    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function convertEncoding($string, $from, $to) {
    return recode_string($from . '..' . $to, $string);
  }

}
