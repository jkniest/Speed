<?php

namespace Tests\Unit;

use App\Models\Server;
use App\Models\Test;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ServerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_be_fetched_via_token()
    {
        // Given: A server exists
        $server = $this->create(Server::class);

        // When: The server is fetched via token
        $result = Server::getByToken($server->token);

        // Then: The servers should be equals
        $this->assertEquals($server->id, $result->id);
    }

    /** @test */
    public function it_can_return_all_related_tests()
    {
        // Given: A server with three speed tests (and one speedtest of another server)
        $server = $this->create(Server::class);
        $this->create(Test::class, ['server_id' => $server->id], 3);
        $this->create(Test::class);

        // When: We fetch all related tests
        $tests = $server->tests();

        // Then: The amount should be 3
        $this->assertCount(3, $tests->get());
    }

    /** @test */
    public function it_can_return_the_average_download_speed()
    {
        // Given: A server with three speed tests
        $server = $this->create(Server::class);
        $this->create(Test::class, ['down_speed' => 100000, 'server_id' => $server->id]);
        $this->create(Test::class, ['down_speed' => 50000, 'server_id' => $server->id]);
        $this->create(Test::class, ['down_speed' => 130000, 'server_id' => $server->id]);

        // When: We fetch the average download speed..
        $downloadSpeed = $server->getAverageDownload();

        // Then: The value should be 93.333
        $this->assertEquals(93333, $downloadSpeed);
    }

    /** @test */
    public function it_can_return_the_average_upload_speed()
    {
        // Given: A server with three speed tests
        $server = $this->create(Server::class);
        $this->create(Test::class, ['up_speed' => 1000, 'server_id' => $server->id]);
        $this->create(Test::class, ['up_speed' => 5000, 'server_id' => $server->id]);
        $this->create(Test::class, ['up_speed' => 4500, 'server_id' => $server->id]);

        // When: We fetch the average upload speed..
        $uploadSpeed = $server->getAverageUpload();

        // Then: The value should be 3.500
        $this->assertEquals(3500, $uploadSpeed);
    }

    /** @test */
    public function it_can_cache_the_average_download_speed()
    {
        // Given: A server with two speed tests
        $server = $this->create(Server::class);
        $this->create(Test::class, ['down_speed' => 100000, 'server_id' => $server->id]);
        $this->create(Test::class, ['down_speed' => 50000, 'server_id' => $server->id]);

        // When: We fetch the average download speed
        $downloadSpeed = $server->getAverageDownload();

        // Then: The value should be 75.000
        $this->assertEquals(75000, $downloadSpeed);

        // Given: Another speedtest is added
        $this->create(Test::class, ['down_speed' => 50000, 'server_id' => $server->id]);

        // When: We fetch the average download speed again
        $downloadSpeed = $server->getAverageDownload();

        // Then: The average speed should be 75.000 (cached)
        $this->assertEquals(75000, $downloadSpeed);
    }

    /** @test */
    public function it_can_cache_the_average_upload_speed()
    {
        // Given: A server with two speed tests
        $server = $this->create(Server::class);
        $this->create(Test::class, ['up_speed' => 1000, 'server_id' => $server->id]);
        $this->create(Test::class, ['up_speed' => 5000, 'server_id' => $server->id]);

        // When: We fetch the average upload speed
        $uploadSpeed = $server->getAverageUpload();

        // Then: The average speed should be 3.000
        $this->assertEquals(3000, $uploadSpeed);

        // Given: Another speedtest is added
        $this->create(Test::class, ['up_speed' => 4500, 'server_id' => $server->id]);

        // When: We fetch the average upload speed again
        $uploadSpeed = $server->getAverageUpload();

        // Then: The average speed should be 3.000 (cached)
        $this->assertEquals(3000, $uploadSpeed);
    }
}
