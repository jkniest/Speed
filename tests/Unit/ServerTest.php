<?php

namespace Tests\Unit;

use App\Models\Server;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
}
