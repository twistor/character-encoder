<?php

/**
 * @file
 * Contains \CharacterEncoder\EncoderBase.
 */

namespace CharacterEncoder;

/**
 * Base class for encoder classes.
 */
abstract class EncoderBase implements Encoder {

  /**
   * The list of encodings to search through.
   *
   * @var array
   */
  private $encodings;

  /**
   * {@inheritdoc}
   */
  public function getEncodings() {
    return $this->encodings;
  }

  /**
   * {@inheritdoc}
   */
  public function setEncodings(array $encodings) {
    $this->encodings = array_unique(array_filter($encodings));
  }

  /**
   * {@inheritdoc}
   */
  public function convertToUtf8($string, $from) {
    return $this->convertEncoding($string, $from, 'utf-8')
  }

}
