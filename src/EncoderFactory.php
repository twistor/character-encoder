<?php

/**
 * @file
 * Contains \CharacterEncoder\EncoderFactory.
 */

namespace CharacterEncoder;

/**
 * Factory used to detect the best encoder.
 */
class EncoderFactory {

  /**
   * Returns the best encoder for the system.
   *
   * @param array $encoding_list
   *   (optional) The list of encodings to search through. Defaults to an empty
   *   array.
   *
   * @return \CharacterEncoder\Encoder
   *   A character encoder.
   */
  public static function create(array $encoding_list = array()) {
    if (extension_loaded('mbstring')) {
      $encoder = new MbEncoder();
    }

    elseif (extension_loaded('iconv')) {
      $encoder = new IconvEncoder();
    }

    elseif (extension_loaded('recode')) {
      $encoder = new RecodeEncoder();
    }

    // No text encoding library found.
    else {
      $encoder = new NoopEncoder();
    }

    $encoder->setEncodings($encoding_list);

    return $encoder;
  }

}
