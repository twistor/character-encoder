<?php

/**
 * @file
 * Contains \CharacterEncoder\Encodings.
 */

namespace CharacterEncoder;

/**
 * Various lists of encodings.
 */
class Encodings {

    /**
     * Common web encodings.
     *
     * @var string[]
     */
    protected static $commonWeb = array(
        'UTF-8',
        'ISO-8859-1',
        'Windows-1251',
        'GB2312',
        'SJIS-win',
        'Windows-1252',
        'GBK',
        'EUC-KR',
        'EUC-JP',
        'ISO-8859-2',
        'ISO-8859-15',
        'Windows-1256',
        'Windows-1250',
        'ISO-8859-9',
        'Windows-1254',
        'Big5',
        'Windows-874',
    );

    /**
     * Less common web encodings.
     *
     * @var string[]
     */
    protected static $lessCommonWeb = array(
        'TIS-620',
        'ISO-8859-7',
        'Windows-1255',
        'KOI8-R',
        'Windows-1253',
        'Windows-1257',
        'KS C 5601',
        'UTF-16',
        'Windows-31J',
        'UTF-7',
        'GB18030',
        'ISO-8859-5',
        'ISO-8859-6',
        'ISO-8859-8',
        'ISO-8859-4',
        'KOI8-U',
        'ISO-8859-16',
        'ISO-2022-JP',
        'ISO-8859-13',
        'ANSI_X3.110-1983',
        'ISO-8859-3',
        'Windows-949',
        'Big5 HKSCS',
        'ISO-8859-11',
        'Windows-1258',
        'ISO-8859-10',
        'IBM850',
        'ISO-8859-14',
    );

    /**
     * Returns common web encodings.
     *
     * @return string[]
     *   A list of common web encodings.
     */
    public static function getCommonWebEncodings() {
        return static::$commonWeb;
    }

    /**
     * Returns a large list of web encodings.
     *
     * @return string[]
     *   More web encodings.
     */
    public static function getUncommonWebEncodings() {
        return array_merge(static::$commonWeb, static::$lessCommonWeb);
    }

}
