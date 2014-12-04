<?php

/**
 * @file
 * Contains \CharacterEncoder\EncoderBase.
 */

namespace CharacterEncoder;

/**
 * Base class for encoder classes.
 */
abstract class EncoderBase implements Encoder
{
    /**
     * The list of utf-8 compatible encodings.
     *
     * In the format array('encoding-name' => true).
     *
     * @var array
     */
    protected static $utf8Compatible = array(
        'utf-8' => true,
        'us-ascii' => true,
        'ascii' => true,
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
    public function getEncodings()
    {
        return $this->encodings;
    }

    /**
     * {@inheritdoc}
     */
    public function setEncodings(array $encodings)
    {
        $this->encodings = array_unique(array_filter($encodings));
    }

    /**
     * {@inheritdoc}
     */
    public function toUtf8($string)
    {
        if (!$detected = $this->detectEncoding($string)) {
            return false;
        }

        if (isset(static::$utf8Compatible[strtolower($detected)])) {
            return $string;
        }

        return $this->convert($string, $detected, 'utf-8');
    }
}
