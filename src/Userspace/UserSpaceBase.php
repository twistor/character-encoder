<?php

namespace CharacterEncoder\Userspace;

class UserSpaceBase
{
    protected static $cache = array();

    public function readResource($label)
    {
        if (isset(static::$cache[$label])) {
            return static::$cache[$label];
        }

        $handle = fopen($this->getResourcePath($label), 'r');

        if (!$handle) {
            throw new \InvalidArgumentException();
        }

        $this->readFile($handle, static::$cache[$label]);

        fclose($handle);

        return static::$cache[$label];
    }

    protected function readFile($handle, &$output)
    {
        while ($line = fgets($handle)) {
            if ($line[0] === '#' || $line === "\n") {
                continue;
            }

            // Get the position of the first tab.
            $first = strpos($line, "\t");
            $pointer = ltrim(substr($line, 0, $first), ' ');

            // The code point is 6 character after the first tab.
            $output[$pointer] = hexdec(rtrim(substr($line, $first+1, 7)));
        }
    }

    protected function getResourcePath($label)
    {
        return dirname(dirname(dirname(__FILE__))).'/resources/index-'.$label.'.txt';
    }
}
