<?php

namespace Tests\Feature\Api;

use App\Models\Server;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SpeedtestTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function the_result_of_a_speedtest_can_be_added()
    {
        // Given: A server exists
        $server = $this->create(Server::class);

        // When: A new test is submitted
        $this->post('/api/result', [
            'token' => $server->token,
            'up'    => '120000',
            'down'  => '500000'
        ]);

        // Then: A new test should be added
        $this->assertDatabaseHas('tests', [
            'server_id'  => $server->id,
            'down_speed' => '500000',
            'up_speed'   => '120000'
        ]);

        // And: The last test should be makred inside the server
        $this->assertEquals(Carbon::now(), $server->fresh()->last_test);
    }

    /** @test */
    public function a_token_is_required_to_add_a_result()
    {
        $this->withExceptionHandling();

        // When: A new post is submitted without a token
        $response = $this->postJson('/api/result', [
            'up'   => '120000',
            'down' => '500000'
        ]);

        // Then: There should be an error related to 'token'
        $response->assertStatus(422);
        $response->assertSee('token');
    }

    /** @test */
    public function a_valid_token_is_required_to_add_a_result()
    {
        $this->withExceptionHandling();

        // When: A new post is submitted with an invalid token
        $response = $this->postJson('/api/result', [
            'token' => 'invalid',
            'up'    => '120000',
            'down'  => '500000'
        ]);

        // Then: There should be an error related to 'token'
        $response->assertStatus(422);
        $response->assertSee('token');
    }

    /** @test */
    public function a_down_speed_is_required_to_add_a_result()
    {
        $this->withExceptionHandling();

        // Given: A server exists
        $server = $this->create(Server::class);

        // When: A new post is submitted without the down speed
        $response = $this->postJson('/api/result', [
            'token' => $server->token,
            'up'    => '120000'
        ]);

        // Then: There should be an error related to 'down'
        $response->assertStatus(422);
        $response->assertSee('down');
    }

    /** @test */
    public function a_up_speed_is_required_to_add_a_result()
    {
        $this->withExceptionHandling();

        // Given: A server exists
        $server = $this->create(Server::class);

        // When: A new post is submitted without the up speed
        $response = $this->postJson('/api/result', [
            'token' => $server->token,
            'down'  => '500000'
        ]);

        // Then: There should be an error related to 'up'
        $response->assertStatus(422);
        $response->assertSee('up');
    }
}
