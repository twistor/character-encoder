character-encoder
=================

[![Build Status](https://img.shields.io/travis/twistor/character-encoder/master.svg?style=flat-square)](https://travis-ci.org/twistor/character-encoder)

PHP library for detecting and converting character encodings.

The currently supported conversion methods are:
- mbstring
- iconv
- recode

Quick usage:
```php
<?php

use CharacterEncoder\EncoderFactory;

$sample = 'The quick brown fox jumps over the lazy dog';

$encodings = array('utf-8', 'EUC-JP', 'ISO-8859-1');
$encoder = EncoderFactory::create($encodings);

// Convert text to utf-8. Returns false if the encoding could not be detected.
$utf8 = $encoder->toUtf8($sample);

// Advanced usage.

// Returns false if the encoding could not be detected.
$detected = $encoder->detect($sample);

$iso = $encoder->convert($sample, $detected, 'ISO-8859-1');
```
