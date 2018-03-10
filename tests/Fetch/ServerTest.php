<?php

namespace Fetch\Test;

use PHPUnit\Framework\TestCase;
use Fetch\Tests\Support\ServerAwareTrait;

/**
 * Fetch\Test\ServerTest
 *
 * @package Fetch\Test
 */
class ServerTest extends TestCase
{
    use ServerAwareTrait;

    /**
     * @test
     * @dataProvider flagsDataProvider
     * @param string $expectedPattern Server pattern string with %host% placeholder
     * @param int    $port            To use (needed to test behavior on port 143 and 993 from constructor)
     * @param array  $flags           To set/unset ($flag => $value)
     */
    public function shouldSetServerFlags(string $expectedPattern, int $port, array $flags)
    {
        $server = $this->createServer($port);

        foreach ($flags as $flag => $value) {
            $server->setFlag($flag, $value);
        }

        $expected = str_replace('%host%', $_ENV['TESTING_SERVER_HOST'], $expectedPattern);
        $this->assertSame($expected, $server->getServerString());
    }

    /** @test */
    public function shouldOverwriteFlags()
    {
        $server = $this->createServer();

        $server->setFlag('TestFlag', 'true');
        $this->assertAttributeContains('TestFlag=true', 'flags', $server);

        $server->setFlag('TestFlag', 'false');
        $this->assertAttributeContains('TestFlag=false', 'flags', $server);
    }

    /**
     * @test
     * @dataProvider connectionDataProvider
     * @param integer $port    To use (needed to test behavior on port 143 and 993 from constructor)
     * @param array   $flags   To set/unset ($flag => $value)
     * @param string  $message Assertion message
     */
    public function testConnection(int $port, array $flags, string $message)
    {
        $server = $this->createServer($port);

        foreach ($flags as $flag => $value) {
            $server->setFlag($flag, $value);
        }

        $imapSteam = $server->getImapStream();
        $this->assertInternalType('resource', $imapSteam, $message);
    }

    public function flagsDataProvider()
    {
        return [
            ['{%host%:143/novalidate-cert}', 143, []                              ],
            ['{%host%:143/validate-cert}',   143, ['validate-cert' => true]       ],
            ['{%host%:143}',                 143, ['novalidate-cert' => false]    ],
            ['{%host%:993/ssl}',             993, []                              ],
            ['{%host%:993}',                 993, ['ssl' => false]                ],
            ['{%host%:100}',                 100, ['ssl' => false]                ],
            ['{%host%:100/ssl}',             100, ['ssl' => true]                 ],
            ['{%host%:100/tls}',             100, ['tls' => true]                 ],
            ['{%host%:100}',                 100, ['tls' => false]                ],
            ['{%host%:100/notls}',           100, ['tls' => true, 'notls' => true]],
            ['{%host%:100/user=foo}',        100, ['user' => 'foo']               ],
            ['{%host%:100/user=bar}',        100, ['user' => 'bar']               ],
            ['{%host%:100}',                 100, ['user' => false]               ],
        ];
    }

    public function connectionDataProvider()
    {
        return [
            [143, [],                          'Connects with default settings.' ],
            [993, ['novalidate-cert' => true], 'Connects over SSL (self signed).'],
        ];
    }
}
