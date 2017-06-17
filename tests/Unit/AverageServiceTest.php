<?php

namespace Tests\Unit;

use App\Services\AverageService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Server;

class AverageServiceTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_return_the_average_down_speed()
    {
        // Given: A single server with thee speed tests: 100.000, 240.000, 47.000
        tap($this->create(Server::class), function ($server) {
            collect([100000, 240000, 47000])
                ->each(function ($speed) use ($server) {
                    DB::table('tests')->insert([
                        'server_id'  => $server->id,
                        'down_speed' => $speed,
                        'up_speed'   => 1
                    ]);
                });
        });

        // When: We fetch the averge down speed
        $downSpeed = app(AverageService::class)->getDown();

        // Then: The average speed should be 129.000
        $this->assertEquals(129000, $downSpeed);
    }

    /** @test */
    public function it_can_cache_the_average_down_speed()
    {
        // Given: A single server with two speed tests: 100.000, 240.000
        $server = $this->create(Server::class);
        collect([100000, 240000])
            ->each(function ($speed) use ($server) {
                DB::table('tests')->insert([
                    'server_id'  => $server->id,
                    'down_speed' => $speed,
                    'up_speed'   => 1
                ]);
            });

        // When: We fetch the average down speed
        $downSpeed = app(AverageService::class)->getDown();

        // Then: The average speed should be 170.000
        $this->assertEquals(170000, $downSpeed);

        // Given: Another speedtest is added
        DB::table('tests')->insert([
            'server_id'  => $server->id,
            'down_speed' => '213000',
            'up_speed'   => 1
        ]);

        // When: We fetch the average down speed again
        $downSpeed = app(AverageService::class)->getDown();

        // Then: The average speed should be 170.000 (cached)
        $this->assertEquals(170000, $downSpeed);
    }

    /** @test */
    public function it_can_return_the_average_up_speed()
    {
        // Given: A single server with thee speed tests: 25.000, 11.000, 3.000
        tap($this->create(Server::class), function ($server) {
            collect([25000, 11000, 3000])
                ->each(function ($speed) use ($server) {
                    DB::table('tests')->insert([
                        'server_id'  => $server->id,
                        'down_speed' => 1,
                        'up_speed'   => $speed
                    ]);
                });
        });

        // When: We fetch the averge up speed
        $upSpeed = app(AverageService::class)->getUp();

        // Then: The average speed should be 13.000
        $this->assertEquals(13000, $upSpeed);
    }

    /** @test */
    public function it_can_cache_the_average_up_speed()
    {
        // Given: A single server with two speed tests: 25.000, 11.000
        $server = $this->create(Server::class);
        collect([25000, 11000])
            ->each(function ($speed) use ($server) {
                DB::table('tests')->insert([
                    'server_id'  => $server->id,
                    'down_speed' => 1,
                    'up_speed'   => $speed
                ]);
            });

        // When: We fetch the average up speed
        $upSpeed = app(AverageService::class)->getUp();

        // Then: The average speed should be 18.000
        $this->assertEquals(18000, $upSpeed);

        // Given: Another speedtest is added
        DB::table('tests')->insert([
            'server_id'  => $server->id,
            'down_speed' => 1,
            'up_speed'   => 12000
        ]);

        // When: We fetch the average up speed again
        $upSpeed = app(AverageService::class)->getUp();

        // Then: The average speed should be 18.000 (cached)
        $this->assertEquals(18000, $upSpeed);
    }

    /** @test */
    public function it_can_return_the_average_down_speed_by_time()
    {
        // Given: A server with three speed test (two on 2am and one on 3am)
        tap($this->create(Server::class), function ($server) {
            collect([20000, 40000])->each(function ($speed) use ($server) {
                DB::table('tests')->insert([
                    'server_id'  => $server->id,
                    'down_speed' => $speed,
                    'up_speed'   => 1,
                    'created_at' => Carbon::create(2017, 5, 1, 2)
                ]);
            });

            DB::table('tests')->insert([
                'server_id'  => $server->id,
                'down_speed' => 15000,
                'up_speed'   => 1,
                'created_at' => Carbon::create(2017, 5, 1, 3)
            ]);
        });

        // When: We fetch the average speed for 2am
        $average = app(AverageService::class)->getDown(2);

        // Then: The average speed should be 30.000
        $this->assertEquals(30000, $average);

        // When: We fetch the average speed for 3am
        $average = app(AverageService::class)->getDown(3);

        // Then: The average speed should be 15.000
        $this->assertEquals(15000, $average);
    }

    /** @test */
    public function it_can_return_the_average_up_speed_by_time()
    {
        // Given: A server with three speed test (two on 10am and one on 4am)
        tap($this->create(Server::class), function ($server) {
            collect([10000, 6000])->each(function ($speed) use ($server) {
                DB::table('tests')->insert([
                    'server_id'  => $server->id,
                    'down_speed' => 1,
                    'up_speed'   => $speed,
                    'created_at' => Carbon::create(2017, 5, 1, 10)
                ]);
            });

            DB::table('tests')->insert([
                'server_id'  => $server->id,
                'down_speed' => 1,
                'up_speed'   => 1000,
                'created_at' => Carbon::create(2017, 5, 1, 4)
            ]);
        });

        // When: We fetch the average speed for 10am
        $average = app(AverageService::class)->getUp(10);

        // Then: The average speed should be 8.000
        $this->assertEquals(8000, $average);

        // When: We fetch the average speed for 4am
        $average = app(AverageService::class)->getUp(4);

        // Then: The average speed should be 1.000
        $this->assertEquals(1000, $average);
    }

    /** @test */
    public function the_average_speed_is_rounded_to_an_integer()
    {
        // Given: A server with two speed tests
        tap($this->create(Server::class), function ($server) {
            collect([10012, 6345])->each(function ($speed) use ($server) {
                DB::table('tests')->insert([
                    'server_id'  => $server->id,
                    'down_speed' => $speed,
                    'up_speed'   => $speed,
                    'created_at' => Carbon::now()
                ]);
            });
        });

        // When: We fetch the average download speed
        $average = app(AverageService::class)->getDown();

        // Then: The average speed should be 8.179
        $this->assertEquals(8179, $average);

        // When: We fetch the average upload speed
        $average = app(AverageService::class)->getUp();

        // Then: The average speed should be 8.179
        $this->assertEquals(8179, $average);
    }
}
