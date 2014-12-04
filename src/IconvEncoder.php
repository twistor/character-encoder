<?php

/**
 * @file
 * Contains \CharacterEncoder\IconvEncoder.
 */

namespace CharacterEncoder;

/**
 * Character encoding using the iconv extension.
 */
class IconvEncoder extends EncoderBase {

  /**
   * {@inheritdoc}
   */
  public function detectEncoding($string) {
    foreach ($this->encodingList as $encoding) {
      if (@iconv($encoding, $encoding, $string) === $string) {
        return $encoding;
      }
    }

    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function convertEncoding($string, $from) {
    return @iconv($from, $to, $string);
  }

}
