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
    public function detectFile($handle, $length = 524288)
    {
        fseek($handle, 0);
        $encoding = $this->detect(fread($handle, $length));
        fseek($handle, 0);

        return $encoding;
    }

    /**
     * {@inheritdoc}
     */
    public function convertFile($handle, $from, $to)
    {
        fseek($handle, 0);
        $output = fopen('php://temp', 'w+');

        // Encode one line at a time.
        // We can't just read a big buffer of bytes since it might split in the
        // middle of a multi-byte character. Newline is safe to split on.
        while ($buffer = fgets($handle)) {
            fwrite($output, $this->convert($buffer, $from, $to));
        }

        fseek($handle, 0);
        fseek($output, 0);

        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function toUtf8($string)
    {
        if (!$detected = $this->detect($string)) {
            return false;
        }

        if (isset(static::$utf8Compatible[strtolower($detected)])) {
            return $string;
        }

        return $this->convert($string, $detected, 'utf-8');
    }
}
