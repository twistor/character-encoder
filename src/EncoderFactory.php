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
   *   The list of encodings to search through.
   *
   * @return \CharacterEncoder\Encoder
   *   A character encoder.
   */
  public static function create(array $encoding_list) {
    if (extension_loaded('mbstring')) {
      return new MbEncoder($encoding_list);
    }

    if (extension_loaded('iconv')) {
      return new IconvEncoder($encoding_list);
    }

    if (extension_loaded('recode')) {
      return new RecodeEncoder($encoding_list);
    }

    // No text encoding library found.
    return new NoopEncoder($encoding_list);
  }

}
