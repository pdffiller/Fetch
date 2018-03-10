<?php

namespace Fetch\Test;

use Fetch\Server;
use PHPUnit\Framework\TestCase;

/**
 * Fetch\Test\ServerTest
 *
 * @package Fetch\Test
 */
class ServerTest extends TestCase
{
    /**
     * @test
     * @dataProvider flagsDataProvider
     * @param string $expectedPattern Server pattern string with %host% placeholder
     * @param int    $port            To use (needed to test behavior on port 143 and 993 from constructor)
     * @param array  $flags           To set/unset ($flag => $value)
     */
    public function shouldSetServerFlags(string $expectedPattern, int $port, array $flags)
    {
        $server = new Server($_ENV['TESTING_SERVER_HOST'], $port);

        foreach ($flags as $flag => $value) {
            $server->setFlag($flag, $value);
        }

        $expected = str_replace('%host%', $_ENV['TESTING_SERVER_HOST'], $expectedPattern);
        $this->assertSame($expected, $server->getServerString());
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
}
