<?php

namespace FiskalyClient;

use Exception;
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../examples/env.php');

class FiskalyClientTest extends TestCase
{

    /**
     * @return FiskalyClient
     */
    public function createClient()
    {
        try {
            return FiskalyClient::createUsingCredentials($_ENV["FISKALY_SERVICE_URL"], $_ENV["FISKALY_API_KEY"], $_ENV["FISKALY_API_SECRET"], 'https://kassensichv.io/api/v1');
        } catch (Exception $e) {
            exit($e);
        }
    }

    /**
     * @test
     */
    public function testClient()
    {
        $client = $this->createClient();
        $this->assertNotNull($client);
        $this->assertTrue($client instanceof FiskalyClient);
    }
}
