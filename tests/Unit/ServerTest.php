<?php

namespace Tests\Unit;

use App\Models\Server;
use App\Models\Test;
use Carbon\Carbon;
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
    public function it_can_return_the_average_download_speed_by_time()
    {
        // Given: A server with three speed test (two on 2am and one on 3am)
        $server = $this->create(Server::class);
        $this->create(Test::class, [
            'down_speed' => 100000,
            'server_id'  => $server->id,
            'created_at' => Carbon::createFromTime(2)
        ]);
        $this->create(Test::class, [
            'down_speed' => 50000,
            'server_id'  => $server->id,
            'created_at' => Carbon::createFromTime(2)
        ]);
        $this->create(Test::class, [
            'down_speed' => 130000,
            'server_id'  => $server->id,
            'created_at' => Carbon::createFromTime(3)
        ]);

        // When: We fetch the average speed for 2am
        $average = $server->getAverageDownload(2);

        // Then: The average speed should be 75.000
        $this->assertEquals(75000, $average);

        // When: We fetch the average speed for 3am
        $average = $server->getAverageDownload(3);

        // Then: The average speed should be 130.000
        $this->assertEquals(130000, $average);
    }

    /** @test */
    public function it_can_return_the_average_upload_speed_by_time()
    {
        // Given: A server with three speed test (two on 10am and one on 8am)
        $server = $this->create(Server::class);
        $this->create(Test::class, [
            'up_speed'   => 1500,
            'server_id'  => $server->id,
            'created_at' => Carbon::createFromTime(10)
        ]);
        $this->create(Test::class, [
            'up_speed'   => 2600,
            'server_id'  => $server->id,
            'created_at' => Carbon::createFromTime(10)
        ]);
        $this->create(Test::class, [
            'up_speed'   => 4500,
            'server_id'  => $server->id,
            'created_at' => Carbon::createFromTime(8)
        ]);

        // When: We fetch the average speed for 10am
        $average = $server->getAverageUpload(10);

        // Then: The average speed should be 2050
        $this->assertEquals(2050, $average);

        // When: We fetch the average speed for 8am
        $average = $server->getAverageUpload(8);

        // Then: The average speed should be 4500
        $this->assertEquals(4500, $average);
    }

    /** @test */
    public function it_can_return_all_download_test_results_grouped_by_hour()
    {
        // Given: A server with three speedtest (two = 4am, one = 5am, three = 11am)
        $server = $this->create(Server::class);
        $this->create(Test::class, [
            'server_id'  => $server->id,
            'down_speed' => '100000',
            'created_at' => Carbon::createFromTime(4)
        ], 2);
        $this->create(Test::class, [
            'server_id'  => $server->id,
            'down_speed' => '50000',
            'created_at' => Carbon::createFromTime(5)
        ]);
        $this->create(Test::class, [
            'server_id'  => $server->id,
            'down_speed' => '100400',
            'created_at' => Carbon::createFromTime(11)
        ], 3);

        // When: We fetch all results based on hour
        $results = $server->getAverageDownloadArray();

        // Then: The array should have 24 entries
        $this->assertCount(24, $results);

        // And: The 4th result should be 100.000
        $this->assertEquals(100000, $results[4]);

        // And: The 5th result should be 50.000
        $this->assertEquals(50000, $results[5]);

        // And: The 11th result should be 100.400
        $this->assertEquals(100400, $results[11]);

        // And: The 13th result should be 0
        $this->assertEquals(0, $results[13]);
    }

    /** @test */
    public function it_can_return_all_upload_test_results_grouped_by_hour()
    {
        // Given: A server with three speedtest (two = 11am, one = 4am, three = 1am)
        $server = $this->create(Server::class);
        $this->create(Test::class, [
            'server_id'  => $server->id,
            'up_speed'   => '1500',
            'created_at' => Carbon::createFromTime(11)
        ], 2);
        $this->create(Test::class, [
            'server_id'  => $server->id,
            'up_speed'   => '2450',
            'created_at' => Carbon::createFromTime(4)
        ]);
        $this->create(Test::class, [
            'server_id'  => $server->id,
            'up_speed'   => '530',
            'created_at' => Carbon::createFromTime(1)
        ], 3);

        // When: We fetch all results based on hour
        $results = $server->getAverageUploadArray();

        // Then: The array should have 24 entries
        $this->assertCount(24, $results);

        // And: The 11th result should be 1500
        $this->assertEquals(1500, $results[11]);

        // And: The 4th result should be 2450
        $this->assertEquals(2450, $results[4]);

        // And: The 1st result should be 530
        $this->assertEquals(530, $results[1]);

        // And: The 13th result should be 0
        $this->assertEquals(0, $results[13]);
    }
}