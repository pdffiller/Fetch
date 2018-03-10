<?php

namespace Fetch\Tests\Support;

use Fetch\Server;

/**
 * Fetch\Tests\Support\ServerAwareTrait
 *
 * @package Fetch\Tests\Support
 */
trait ServerAwareTrait
{
    protected function createServer($port = null): Server
    {
        $server = new Server($_ENV['TESTING_SERVER_HOST'], $port ?? $_ENV['TESTING_SERVER_PORT']);
        $server->setAuthentication($_ENV['TEST_USER'], $_ENV['TEST_PASSWORD']);

        return $server;
    }
}
