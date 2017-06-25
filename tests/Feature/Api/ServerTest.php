<?php

namespace Tests\Feature\Api;

use App\Models\Server;
use App\Models\Test;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ServerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_change_the_name_of_a_server()
    {
        // Given: A server exists with a specific name (Pilzman)
        $server = $this->create(Server::class, ['name' => 'Pilzman']);

        // When: We try to change the name with the token
        $this->patchJson('/api/server', [
            'token' => $server->token,
            'name'  => 'Super-Pilz'
        ]);

        // Then: The name should be changed
        $this->assertEquals('Super-Pilz', $server->fresh()->name);
    }

    /** @test */
    public function a_token_is_required_to_change_the_name()
    {
        $this->withExceptionHandling();

        // When: We try to change the name without the token
        $response = $this->patchJson('/api/server', [
            'name' => 'Super-Pilz'
        ]);

        // Then: The response should have an error related to 'token'
        $response->assertStatus(422);
        $response->assertSee('token');
    }

    /** @test */
    public function the_token_must_be_valid_to_change_the_name()
    {
        $this->withExceptionHandling();

        // When: We try to change the name with an invalid token
        $response = $this->patchJson('/api/server', [
            'token' => 'invalid',
            'name'  => 'Super-Pilz'
        ]);

        // Then: The response should have an error related to 'token'
        $response->assertStatus(422);
        $response->assertSee('token');
    }

    /** @test */
    public function a_name_is_required_to_change_the_name()
    {
        $this->withExceptionHandling();

        // Given: A server, named 'Pilzman' exists
        $server = $this->create(Server::class, ['name' => 'Pilzman']);

        // When: We try to change the name without a name ^^
        $response = $this->patchJson('/api/server', [
            'token' => $server->token
        ]);

        // Then: The response should have an error related to 'name'
        $response->assertStatus(422);
        $response->assertSee('name');

        // And: The name should not be changed
        $this->assertEquals('Pilzman', $server->fresh()->name);
    }

    /** @test */
    public function a_server_can_be_deleted()
    {
        // Given: A server with three tests
        $server = $this->create(Server::class);
        $this->create(Test::class, ['server_id' => $server->id], 3);

        // When: We try to delete the server with the valid token
        $this->deleteJson('/api/server', [
            'token' => $server->token
        ]);

        // Then: The server should not exists anymore
        $this->assertCount(0, Server::all());

        // Also: All tests should be deleted
        $this->assertCount(0, Test::all());
    }

    /** @test */
    public function a_token_is_required_to_delete_a_server()
    {
        $this->withExceptionHandling();

        // When: We try to delete the server without the token
        $response = $this->deleteJson('/api/server');

        // Then: The response should have an error related to 'token'
        $response->assertStatus(422);
        $response->assertSee('token');
    }

    /** @test */
    public function the_token_must_be_valid_to_delete_the_server()
    {
        $this->withExceptionHandling();

        // When: We try to delete the server with an invalid token
        $response = $this->deleteJson('/api/server', [
            'token' => 'invalid'
        ]);

        // Then: The response should have an error related to 'token'
        $response->assertStatus(422);
        $response->assertSee('token');
    }

    /** @test */
    public function the_cache_should_be_cleared_when_a_server_is_deleted()
    {
        // Given: A server exists
        $server = $this->create(Server::class);

        // Given: A dummy data inside the cache
        cache(['sample' => 'hello world'], 20);

        // When: We delete the server
        $this->deleteJson('/api/server', [
            'token' => $server->token
        ]);

        // Then: The cache should be cleared
        $this->assertFalse(cache()->has('sample'));
    }

}
