<?php

use Illuminate\Database\Seeder;

class ServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create n server (1 - 6)
        $servers = collect(factory(\App\Models\Server::class, mt_rand(1, 6))->create());

        $servers->each(function ($server) {

            // Create x tests (1 - 30)
            factory(\App\Models\Test::class, mt_rand(1, 30))->create([
                'server_id' => $server->id
            ]);

        });
    }
}
