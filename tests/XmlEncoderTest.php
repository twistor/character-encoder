<?php

/**
 * @file
 * Contains \CharacterEncoder\Tests\XmlEncoderTest.
 */

namespace CharacterEncoder\Tests;

use CharacterEncoder\Adapter\MbString;
use CharacterEncoder\Encoder;
use CharacterEncoder\XmlEncoder;

/**
 * @covers \CharacterEncoder\XmlEncoder
 */
class XmlEncoderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRfc3203Encoding()
    {
        $xml = <<<XML
<?xml version="1.0" encoding="EUC-JP"?>
<thing>
</thing>
XML;

        $xmlEncoder = new XmlEncoder(new Encoder(new MbString()));
        // Test not Content-Type.
        $this->assertSame('euc-jp', $xmlEncoder->getRfc3203Encoding($xml));

        // // Test application Content-Type.
        $this->assertSame('ascii', $xmlEncoder->getRfc3203Encoding($xml, 'application/xml; charset=ascii'));
        $this->assertSame('ascii', $xmlEncoder->getRfc3203Encoding($xml, 'application/test+xml; charset=ascii'));

        $this->assertSame('ascii', $xmlEncoder->getRfc3203Encoding($xml, 'text/xml; charset=ascii'));
        $this->assertSame('ascii', $xmlEncoder->getRfc3203Encoding($xml, 'text/test+xml; charset=ascii'));
        $this->assertSame('us-ascii', $xmlEncoder->getRfc3203Encoding($xml, 'text/plain'));

        $this->assertSame('euc-jp', $xmlEncoder->getRfc3203Encoding($xml, 'image/jpg'));

        // Test with BOM sniffing.
        $utf32 = "\x00\x00\xFE\xFF".mb_convert_encoding(str_replace('EUC-JP', 'UTF-32BE', $xml), 'UTF-32BE', 'UTF-8');
        $this->assertSame('utf-32be', $xmlEncoder->getRfc3203Encoding($utf32));

        // Test application Content-Type.
        $this->assertSame('ascii', $xmlEncoder->getRfc3203Encoding($utf32, 'application/xml; charset=ascii'));
        $this->assertSame('ascii', $xmlEncoder->getRfc3203Encoding($utf32, 'application/test+xml; charset=ascii'));

        $this->assertSame('ascii', $xmlEncoder->getRfc3203Encoding($utf32, 'text/xml; charset=ascii'));
        $this->assertSame('ascii', $xmlEncoder->getRfc3203Encoding($utf32, 'text/test+xml; charset=ascii'));
        $this->assertSame('us-ascii', $xmlEncoder->getRfc3203Encoding($utf32, 'text/plain'));

        $this->assertSame('utf-32be', $xmlEncoder->getRfc3203Encoding($utf32, 'image/jpg'));
    }
}
