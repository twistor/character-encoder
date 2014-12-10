<?php

/**
 * @file
 * Contains \CharacterEncoder\Encoder.
 */

namespace CharacterEncoder;

use CharacterEncoder\Adapter\Adapter;

/**
 * Converts character encodings.
 */
class Encoder
{
    /**
     * A list of BOM (Byte order mark) identifiers mapped to their encoding.
     *
     * @var array
     */
    protected static $boms = array(
        "\x2B\x2F\x76\x38\x2D" => 'UTF-7',
        "\x00\x00\xFE\xFF" => 'UTF-32BE',
        "\xFF\xFE\x00\x00" => 'UTF-32LE',
        "\x2B\x2F\x76\x38" => 'UTF-7',
        "\x2B\x2F\x76\x39" => 'UTF-7',
        "\x2B\x2F\x76\x2B" => 'UTF-7',
        "\x2B\x2F\x76\x2F" => 'UTF-7',
        "\xDD\x73\x66\x73" => 'UTF-EBCDIC',
        "\x84\x31\x95\x33" => 'GB18030',
        "\xEF\xBB\xBF" => 'UTF-8',
        "\xF7\x64\x4C" => 'UTF-1',
        "\x0E\xFE\xFF" => 'SCSU',
        "\xFB\xEE\x28" => 'BOCU-1',
        "\xFE\xFF" => 'UTF-16BE',
        "\xFF\xFE" => 'UTF-16LE',
    );

    /**
     * The list of utf-8 compatible encodings.
     *
     * In the format array('encoding-name' => true).
     *
     * @todo Add other superset encodings.
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
     * The encoding adapter.
     *
     * @var \CharacterEncoder\Adapter
     */
    private $adapter;

    /**
     * Counstructs an Encoder object.
     *
     * @param Adapter $adapter The encoding adapter.
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Returns the current list of encodings being detected.
     *
     * @return []string A list of character encodings.
     */
    public function getEncodings()
    {
        return $this->encodings;
    }

    /**
     * Sets the list of character encodings to use for detection.
     *
     * @param []string $encodings A list of character encodings.
     */
    public function setEncodings(array $encodings)
    {
        $this->encodings = array_unique(array_filter($encodings));
    }

    /**
     * Checks the encoding of a given string.
     *
     * @param string $string   The string to check the encoding of.
     * @param string $encoding The encoding to test.
     *
     * @return bool True if the encoding is valid, false if not.
     */
    public function checkString($string, $encoding)
    {
        return $this->adapter->check($string, $encoding);
    }

    /**
     * Detects the encoding of a given string.
     *
     * @param string $string      The string to detect the encoding of.
     * @param string $contentType The Content-Type header value if available.
     *
     * @return string|bool The detected character encoding, or false if it couldn't be determined.
     */
    public function detectString($string, $contentType = '')
    {
        // Try charset first.
        if ($contentType && $charset = $this->getCharset($contentType)) {
            if ($this->checkString($string, $charset)) {
                return $charset;
            }
        }
        foreach ($this->getEncodings() as $encoding) {
            if ($this->checkString($string, $encoding)) {
                return $encoding;
            }
        }

        return false;
    }

    /**
     * Converts a string from an encoding to another encoding.
     *
     * This doesn't do any verification of the encoding, so it's possible that
     * the out will be garbled text. Use Encoder::detectString() or
     * Encoder::checkString() to verify the encoding before conversion.
     *
     * @param string $string The string to convert.
     * @param string $from   The encoding of the string.
     * @param string $to     The desired encoding of the string.
     *
     * @return string The encoded string.
     */
    public function convertString($string, $from, $to)
    {
        return $this->adapter->convert($string, $from, $to);
    }

    /**
     * Checks the encoding of a stream.
     *
     * @param resource $stream   A stream handle.
     * @param string   $encoding The encoding to test.
     * @param int      $length   The length of stream to read in bytes. Defaults to 524288 (0.5MB).
     *
     * @return bool True if the encoding is valid, false if not.
     */
    public function checkStream($stream, $encoding, $length = 524288)
    {
        // Skip the BOM if it exists.
        $this->getBomFromStream($stream);

        $valid = $this->checkString(fread($stream, $length), $encoding);
        fseek($stream, 0);

        return $valid;
    }

    /**
     * Detects the encoding of a stream.
     *
     * @param resource $stream      A stream handle.
     * @param int      $length      The number of bytes to read from the stream. Defaults to 524288 (0.5MB).
     * @param string   $contentType The Content-Type header value if available.
     *
     * @return string|bool The detected character encoding, or false if it couldn't be determined.
     */
    public function detectStream($stream, $length = 524288, $contentType = '')
    {
        $bom = $this->getBomFromStream($stream);
        $string = fread($stream, $length);
        fseek($stream, 0);

        // According to RFC, we should check Content-Type before BOM.
        if ($contentType && $charset = $this->getCharset($contentType)) {
            if ($this->checkString($string, $charset)) {
                return $charset;
            }
        }

        if ($bom) {
            $encoding = static::$boms[$bom];
            if ($this->checkString($string, $encoding)) {
                return $encoding;
            }
        }

        return $this->detectString($string);
    }

    /**
     * Converts a stream from one encoding to another.
     *
     * This returns a php://temp stream. To overwrite the existing stream:
     * @code
     * $tmp = $encoder->convertStream($stream, $from, $to);
     * ftruncate($stream, 0);
     * stream_copy_to_stream($tmp, $stream);
     * fclose($tmp);
     * @endcode
     *
     *
     * @param resource $stream A stream handle.
     * @param string   $from   The encoding of the string.
     * @param string   $to     The desired encoding of the string.
     *
     * @return resource A new stream handle with the encoded text.
     */
    public function convertStream($stream, $from, $to)
    {
        // Skip the BOM if it exists.
        $this->getBomFromStream($stream);

        // The output stream.
        $output = fopen('php://temp', 'w+');

        // Encode one line at a time.
        // We can't just read a big buffer of bytes since it might split in the
        // middle of a multi-byte character. Newline is safe to split on.
        while ($buffer = fgets($stream)) {
            fwrite($output, $this->convertString($buffer, $from, $to));
        }

        fseek($stream, 0);
        fseek($output, 0);

        return $output;
    }

    /**
     * Returns the BOM (Byte order mark) from a string.
     *
     * @param string $string A string.
     *
     * @return string|bool The BOM identifier, or false if one wasn't found.
     */
    public function getBomFromString($string)
    {
        // Search for a BOM signature from largest to smallest.
        foreach (range(5, 2) as $bom_len) {
            $test = substr($string, 0, $bom_len);

            if (isset(static::$boms[$test])) {
                return $test;
            }
        }

        return false;
    }

    /**
     * Returns the BOM (Byte order mark) from a stream.
     *
     * If a BOM was found, the stream will be positioned immediately after it.
     *
     * @param resource $stream A stream.
     *
     * @return string|bool The BOM identifier, or false if one wasn't found.
     */
    public function getBomFromStream($stream)
    {
        fseek($stream, 0);
        $bom = $this->getBomFromString(fread($stream, 5));

        $bom ? fseek($stream, strlen($bom)) : fseek($stream, 0);

        return $bom;
    }

    /**
     * Returns the character set from a Content-Type header
     *
     * text/html; charset=utf-8
     *
     * @param string $contentType The Content-Type header string.
     *
     * @return string|bool The charset, or false if not found.
     */
    public function getCharset($contentType)
    {
        if (preg_match('/charset\s*=\s*(.*);?/', $contentType, $matches)) {
            return trim($matches[1]);
        }

        return false;
    }

    /**
     * Returns the mime type from a Content-Type header.
     *
     * @param string $contentType The Content-Type header value.
     *
     * @return string The mime type.
     */
    public function getMimeTypeFromHeader($contentType)
    {
        $paramPos = strpos($contentType, ';');
        // No optional paramaters.
        if ($paramPos === false) {
            return strtolower(trim($contentType));
        }

        return strtolower(trim(substr($contentType, 0, $paramPos)));
    }
}
