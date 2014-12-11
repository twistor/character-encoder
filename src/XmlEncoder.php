<?php

/**
 * @file
 * Contains \CharacterEncoder\XmlEncoder.
 */

namespace CharacterEncoder;

/**
 * Converts XML character encodings.
 */
class XmlEncoder extends Encoder
{
    /**
     * Regex to match the xml charset.
     *
     * @var string
     */
    const XML_ENCODING = '/^<\?.*encoding=[\'"](.*?)[\'"].*\?>/';

    /**
     * Not a valid XML content type.
     *
     * @var int
     */
    const CONENT_TYPE_NOT_XML = 0;

    /**
     * Application XML content type.
     *
     * @var int
     */
    const CONENT_TYPE_APPLICATION = 1;

    /**
     * Text XML content type.
     *
     * @var int
     */
    const CONENT_TYPE_TEXT = 2;

    /**
     * The encoder.
     *
     * @var \CharacterEncoder\Encoder
     */
    private $encoder;

    /**
     * The first four bytes of the XML processing instructions in.
     *
     * '<?xml' in different encodings.
     *
     * @var array
     */
    private static $xmlPreables = array(
        "\x2B\x41\x44\x77" => 'UTF-7',
        "\x3C\x3F\x78\x6D" => 'UTF-8',
        "\x4C\x6F\xA7\x94" => 'EBCDIC-US',
        "\x00\x3C\x00\x3F" => 'UTF-16BE',
        "\x3C\x00\x3F\x00" => 'UTF-16LE',
        "\x00\x00\x00\x3C" => 'UTF-32BE',
        "\x3C\x00\x00\x00" => 'UTF-32LE',
    );

    /**
     * application/xml mime types.
     *
     * @var array
     */
    private static $applicationMimeTypes = array(
        'application/xml' => TRUE,
        'application/xml-dtd' => TRUE,
        'application/xml-external-parsed-entity' => TRUE,
    );

    /**
     * text/xml mime types.
     *
     * @var array
     */
    private static $textMimeTypes = array(
        'text/xml' => TRUE,
        'text/xml-external-parsed-entity' => TRUE,
    );

    /**
     * Counstructs a new XmlEncoder.
     *
     * @param \CharacterEncoder\Encoder $encoder The encoder.
     */
    public function __construct(Encoder $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Detects the encoding of a given XML string.
     *
     * https://www.ietf.org/rfc/rfc3023.txt
     *
     * @param string $string      The XML string to detect the encoding of.
     * @param string $contentType The Content-Type header value if available.
     *
     * @return string The detected character encoding.
     */
    public function getRfc3203Encoding($string, $contentType = '')
    {
        // Parse according to RFC 3023 ('XML Media Types').
        $bomEncoding = '';
        if ($bom = $this->encoder->getBomFromString($string)) {
            $bomEncoding = static::$boms[$bom];
            // Remove the BOM.
            $string = substr($string, strlen($bom));
        } elseif ($hint = $this->getXmlEncodingHint($string)) {
            $bomEncoding = $hint;
        }

        $foundEncoding = '';
        // If we found an encoding hint, convert the first part of the XML file
        // to try and find the actual encoding.
        if ($bomEncoding) {
            $tmpString = $this->encoder->convertString($string, $bomEncoding, 'UTF-8');
            if (preg_match(static::XML_ENCODING, $tmpString, $matches)) {
                $foundEncoding = strtolower($matches[1]);
            }
        }

        if (!$contentType) {
            return $foundEncoding ? $foundEncoding : 'iso-8859-1';
        }

        $mimeType = $this->encoder->getMimeTypeFromHeader($contentType);
        $xmlType = $this->getXmlMimeType($mimeType);
        $charset = $this->encoder->getCharset($contentType);

        switch ($xmlType) {
            case static::CONENT_TYPE_APPLICATION:
                return $charset ? $charset : ($foundEncoding ? $foundEncoding : 'utf-8');

            case static::CONENT_TYPE_TEXT:
                return $charset ? $charset : 'us-ascii';

            default:
                if (strpos($mimeType, 'text/') === 0) {
                    return $charset ? $charset : 'us-ascii';
                }

                return $foundEncoding ? $foundEncoding : 'utf-8';
        }
    }

    /**
     * Tests a string for the XML preamble in different encodings.
     *
     * @param string $string The XML string.
     *
     * @return string The found encoding.
     */
    private function getXmlEncodingHint($string)
    {
        $start = substr($string, 0, 4);

        return isset(static::$xmlPreables[$start]) ? static::$xmlPreables[$start] : '';
    }

    /**
     * Returns the XML mime type of the mime type.
     *
     * @param string $mimeType The mime type.
     *
     * @return int Either CONENT_TYPE_APPLICATION, CONENT_TYPE_TEXT, or CONENT_TYPE_NOT_XML.
     */
    private function getXmlMimeType($mimeType)
    {
        // Check for standard types.
        if (isset(static::$applicationMimeTypes[$mimeType])) {
            return static::CONENT_TYPE_APPLICATION;
        }
        if (isset(static::$textMimeTypes[$mimeType])) {
            return static::CONENT_TYPE_TEXT;
        }

        // Custom types must end in '+xml'.
        if (substr($mimeType, -4) !== '+xml') {
            static::CONENT_TYPE_NOT_XML;
        }

        if (strpos($mimeType, 'application/') === 0) {
            return static::CONENT_TYPE_APPLICATION;
        }

        return static::CONENT_TYPE_NOT_XML;
    }
}
