character-encoder
=================

[![Build Status](https://travis-ci.org/twistor/character-encoder.svg?branch=master)](https://travis-ci.org/twistor/character-encoder)

PHP library for detecting and converting character encodings.

The currently supported conversion methods are:
- mbstring
- iconv
- recode

Quick usage:
```php
<?php
use CharacterEncoder\EncoderFactory;

$encodings = array('utf-8', 'EUC-JP', 'ISO-8859-1');
$encoder = EncoderFactory::create($encodings);

$detected = $encoder->detect($some_text);

$utf8_text = $encoder->convertToUtf8($some_text, $detected);

$iso_text = $encoder->convertEncoding($some_text, $detected, 'ISO-8859-1');
```
