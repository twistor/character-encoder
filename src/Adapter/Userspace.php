<?php

/**
 * @file
 * Contains \CharacterEncoder\Adapter\Userspace.
 */

namespace CharacterEncoder\Adapter;

/**
 * Adapter that does encoding conversions in user space.
 *
 * Not much to see here yet.
 */
class Userspace implements Adapter
{
    /**
     * Cyrillic character sets for use with convert_cyr_string().
     *
     * @var array
     */
    protected static $cyrillic = array(
        'koi8r' => 'k',
        'windows1251' => 'w',
        'iso88595' => 'i',
        'xcp866' => 'a',
        'xmaccyrillic' => 'm',
    );

    /**
     * {@inheritdoc}
     */
    public function check($string, $encoding)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function convert($string, $from, $to)
    {
        // @todo Move to a normalizer.
        $to = str_replace('-', '', strtolower($to));
        $from = str_replace('-', '', strtolower($from));

        if ($to === $from) {
            return $string;
        }

        // We can at least handle these cases for now.
        if ($to === 'utf8' && $from === 'iso88591') {
            return utf8_encode($string);
        }
        if ($to ===  'iso88591' && $from === 'utf8') {
            return utf8_decode($string);
        }

        if (isset(static::$cyrillic[$to]) && isset(static::$cyrillic[$from])) {
            return convert_cyr_string($str, $from, $to);
        }
    }
}
