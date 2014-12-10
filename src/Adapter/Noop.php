<?php

/**
 * @file
 * Contains \CharacterEncoder\Adapter\Noop.
 */

namespace CharacterEncoder\Adapter;

/**
 * Stub adapter thas does nothing.
 */
class Noop implements Adapter
{
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
        return '';
    }
}
