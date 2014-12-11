<?php

/**
 * @file
 * Contains \CharacterEncoder\Encodings.
 */

namespace CharacterEncoder;

/**
 * Various lists of encodings.
 */
class Encodings
{
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
     * @return string[] A list of common web encodings.
     */
    public static function getCommonWebEncodings()
    {
        return static::$commonWeb;
    }

    /**
     * Returns a large list of web encodings.
     *
     * @return string[] More web encodings.
     */
    public static function getUncommonWebEncodings()
    {
        return array_merge(static::$commonWeb, static::$lessCommonWeb);
    }

    /**
     * Normalizes a label.
     *
     * Unicode Technical Standard #22
     * http://www.unicode.org/reports/tr22/
     *
     * @param string $label Encoding label.
     *
     * @return string The normalized label.
     */
    public static function normalize($label)
    {
        $original = $label = strtolower($label);
        $label = preg_replace('/[^a-zA-Z0-9]/', '', $label);
        $label = preg_replace('/(?<!\d)0+/', '', $label);

        return isset(static::$normalizations[$label]) ? static::$normalizations[$label] : $original;
    }

    /**
     * Normalizations.
     *
     * @var array
     */
    protected static $normalizations = array(
        'unicode11utf8' => 'utf-8',
        // Normalize ascii to utf-8 rather than windows-1252.
        'ascii' => 'utf-8',
        'usascii' => 'utf-8',

        '866' => 'ibm866',
        'cp866' => 'ibm866',
        'csibm866' => 'ibm866',

        'csisolatin2' => 'iso-8859-2',
        'isoir101' => 'iso-8859-2',
        'iso88592' => 'iso-8859-2',
        'iso885921987' => 'iso-8859-2',
        'l2' => 'iso-8859-2',
        'latin2' => 'iso-8859-2',

        'csisolatin3' => 'iso-8859-3',
        'isoir109' => 'iso-8859-3',
        'iso88593' => 'iso-8859-3',
        'iso885931988' => 'iso-8859-3',
        'l3' => 'iso-8859-3',
        'latin3' => 'iso-8859-3',

        'csisolatin4' => 'iso-8859-4',
        'isoir110' => 'iso-8859-4',
        'iso88594' => 'iso-8859-4',
        'iso885941988' => 'iso-8859-4',
        'l4' => 'iso-8859-4',
        'latin4' => 'iso-8859-4',

        'csisolatincyrillic' => 'iso-8859-5',
        'cyrillic' => 'iso-8859-5',
        'isoir144' => 'iso-8859-5',
        'iso88595' => 'iso-8859-5',
        'iso885951988' => 'iso-8859-5',

        'arabic' => 'iso-8859-6',
        'asmo708' => 'iso-8859-6',
        'csiso88596e' => 'iso-8859-6',
        'csiso88596i' => 'iso-8859-6',
        'csisolatinarabic' => 'iso-8859-6',
        'ecma114' => 'iso-8859-6',
        'iso88596e' => 'iso-8859-6',
        'iso88596i' => 'iso-8859-6',
        'isoir127' => 'iso-8859-6',
        'iso88596' => 'iso-8859-6',
        'iso885961987' => 'iso-8859-6',

        'csisolatingreek' => 'iso-8859-7',
        'ecma118' => 'iso-8859-7',
        'elot928' => 'iso-8859-7',
        'greek' => 'iso-8859-7',
        'greek8' => 'iso-8859-7',
        'isoir126' => 'iso-8859-7',
        'iso88597' => 'iso-8859-7',
        'iso885971987' => 'iso-8859-7',
        'suneugreek' => 'iso-8859-7',

        'csiso88598e' => 'iso-8859-8',
        'csisolatinhebrew' => 'iso-8859-8',
        'hebrew' => 'iso-8859-8',
        'iso88598e' => 'iso-8859-8',
        'isoir138' => 'iso-8859-8',
        'iso88598' => 'iso-8859-8',
        'iso885981988' => 'iso-8859-8',
        'visual' => 'iso-8859-8',

        'csiso88598i' => 'iso-8859-8-i',
        'logical' => 'iso-8859-8-i',

        'csisolatin6' => 'iso-8859-10',
        'isoir157' => 'iso-8859-10',
        'iso885910' => 'iso-8859-10',
        'l6' => 'iso-8859-10',
        'latin6' => 'iso-8859-10',

        'iso885913' => 'iso-8859-13',

        'iso885914' => 'iso-8859-14',

        'csisolatin9' => 'iso-8859-15',
        'iso885915' => 'iso-8859-15',
        'l9' => 'iso-8859-15',

        'iso885916' => 'iso-8859-16',

        'cskoi8r' => 'koi8-r',
        'koi' => 'koi8-r',
        'koi8' => 'koi8-r',
        'koi8_r' => 'koi8-r',

        'koi8u' => 'koi8-u',

        'csmacintosh' => 'macintosh',
        'mac' => 'macintosh',
        'xmacroman' => 'macintosh',

        'dos874' => 'windows-874',
        'iso885911' => 'windows-874',
        'tis620' => 'windows-874',

        'cp1250' => 'windows-1250',
        'xcp1250' => 'windows-1250',

        'cp1251' => 'windows-1251',
        'xcp1251' => 'windows-1251',

        'ansix341968' => 'windows-1252',
        'cp1252' => 'windows-1252',
        'cp819' => 'windows-1252',
        'csisolatin1' => 'windows-1252',
        'ibm819' => 'windows-1252',
        'iso88591' => 'windows-1252',
        'isoir100' => 'windows-1252',
        'iso885911987' => 'windows-1252',
        'l1' => 'windows-1252',
        'latin1' => 'windows-1252',
        'xcp1252' => 'windows-1252',

        'cp1253' => 'windows-1253',
        'xcp1253' => 'windows-1253',

        'cp1254' => 'windows-1254',
        'csisolatin5' => 'windows-1254',
        'iso88599' => 'windows-1254',
        'isoir148' => 'windows-1254',
        'iso885991989' => 'windows-1254',
        'l5' => 'windows-1254',
        'latin5' => 'windows-1254',
        'xcp1254' => 'windows-1254',

        'cp1255' => 'windows-1255',
        'xcp1255' => 'windows-1255',

        'cp1256' => 'windows-1256',
        'xcp1256' => 'windows-1256',

        'cp1257' => 'windows-1257',
        'xcp1257' => 'windows-1257',

        'cp1258' => 'windows-1258',
        'xcp1258' => 'windows-1258',

        'xmacukrainian' => 'x-mac-cyrillic',

        'chinese' => 'gbk',
        'csgb2312' => 'gbk',
        'csiso58gb231280' => 'gbk',
        'gb2312' => 'gbk',
        'gb231280' => 'gbk',
        'isoir58' => 'gbk',
        'xgbk' => 'gbk',

        'gb18030' => 'gb18030',

        'big5hkscs' => 'big5',
        'cnbig5' => 'big5',
        'csbig5' => 'big5',
        'xxbig5' => 'big5',

        'cseucpkdfmtjapanese' => 'euc-jp',
        'xeucjp' => 'euc-jp',

        'csiso2022jp' => 'iso-2022-jp',

        'csshiftjis' => 'shift_jis',
        'mskanji' => 'shift_jis',
        'shiftjis' => 'shift_jis',
        'sjis' => 'shift_jis',
        'windows31j' => 'shift_jis',
        'xsjis' => 'shift_jis',

        'cseuckr' => 'euc-kr',
        'csksc56011987' => 'euc-kr',
        'isoir149' => 'euc-kr',
        'korean' => 'euc-kr',
        'ksc56011987' => 'euc-kr',
        'ksc5601' => 'euc-kr',
        'windows949' => 'euc-kr',

        'utf32le' => 'utf-32le',
        'utf32' => 'utf-32le',

        'utf32be' => 'utf-32be',
    );
}
