<?php

/**
 * @file
 * Contains \CharacterEncoder\NoopEncoder.
 */

namespace CharacterEncoder;

/**
 * Stub character converter thas does nothing.
 */
class NoopEncoder extends EncoderBase {

  /**
   * {@inheritdoc}
   */
  public function detectEncoding($string) {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function convertEncoding($string, $from, $to) {
    return $string;
  }

}
