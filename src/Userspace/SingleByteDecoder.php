<?php

namespace CharacterEncoder\Userspace;

class SingleByteDecoder extends UserSpaceBase
{
    protected static $cache = array();

    public function decode($string, $label)
    {
        $index = $this->readResource($label);
        $len = strlen($string);

        if (class_exists('\SplFixedArray', false)) {
            $output = new \SplFixedArray($len);
        } else {
            $output = array();
        }

        for ($i = 0; $i < $len; $i++) {
            $value = ord($string[$i]);

            if ($value < 0x80) {
                $output[$i] = $value;
            } else {
                $value = $value ^ 0x80;
                if (isset($index[$value])) {
                    $output[$i] = $index[$value];
                } else {
                    throw new \InvalidArgumentException();
                }
            }
        }

        return $output;
    }

    public function encode($stream, $label)
    {
        $index = array_flip($this->readResource($label));

        $output = '';
        foreach ($stream as $token) {
            if ($token < 0x80) {
                $output .= chr($token);
            } elseif (isset($index[$token])) {
                $output .= chr(0x80 | $index[$token]);
            } else {
                throw new \InvalidArgumentException();
            }
        }

        return $output;
    }
}
