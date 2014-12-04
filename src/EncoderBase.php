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
   * The list of utf-8 compatible encodings.
   *
   * In the format array('encoding-name' => TRUE).
   *
   * @var array
   */
  protected static $utf8Compatible = array(
    'utf-8' => TRUE,
    'us-ascii' => TRUE,
    'ascii' => TRUE,
  );

  /**
   * The list of encodings to search through.
   *
   * @var []string
   */
  private $encodings = array();

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
  public function toUtf8($string) {
    if (!$detected = $this->detectEncoding($string)) {
      return FALSE;
    }

    if (isset(static::$utf8Compatible[strtolower($detected)])) {
      return $string;
    }

    return $this->convert($string, $detected, 'utf-8');
  }

}
