<?php

/**
 * @file
 * Contains \CharacterEncoder\RecodeEncoder.
 */

namespace CharacterEncoder;

/**
 * Character encoding using the iconv extension.
 */
class RecodeEncoder extends EncoderBase {

  /**
   * {@inheritdoc}
   */
  public function detectEncoding($string) {
    foreach ($this->encodingList as $encoding) {
      // recode_string() from..to the same encoding is a noop, so we have to do
      // this dance.
      $to = strtolower($encoding) === 'utf-8' ? 'utf-16' : 'utf-8';
      $test = recode_string($to . '..' . $encoding, recode_string($encoding . '..' . $to, $string));
      if ($test === $string) {
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
