<?php

namespace Tests\Unit;

use Tests\TestCase;

class CIDRTest extends TestCase
{
    /**
     * @test
     * @dataProvider additionProvider
     */
    public function testIsIPAddressIsAPartOfASubnet($input, $expected)
    {
        $new = new CIDR();
        $this->assertSame($expected,$new->isMatch($input['ip'], $input['network'], $input['cidr']));
    }

    public function additionProvider()
    {
        return [
            [['ip' => '192.168.1.250', 'network' => '192.168.1.0', 'cidr' => '24'], true],
            [['ip' => '192.168.50.2', 'network' => '192.168.30.0', 'cidr' => '23'], false],
            [['ip' => '10.5.21.30', 'network' => '10.5.16.0', 'cidr' => '20'], true],
        ];
    }

}

class CIDR
{
    public function isMatch($ip, $network, $cidr)
    {
        return ((ip2long($ip) & ~((1 << (32 - $cidr)) - 1) ) == ip2long($network))?  true:  false;
    }
}
