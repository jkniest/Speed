<?php

namespace Tests\Feature\Commands;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use League\Flysystem\FileNotFoundException;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_be_created()
    {
        // Mock the given command
        $command = \Mockery::mock(
            '\App\Console\Commands\CreateUser[secret]'
        );

        // When a password is needed, pass 'secret'
        $command->shouldReceive('secret')
            ->once()
            ->andReturn('secret');

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        // When: This command is executed
        $this->artisan('create:user', ['username' => 'my-name', '--no-interaction' => true]);

        // Then: The user should be created
        $this->assertDatabaseHas('users', [
            'name' => 'my-name'
        ]);

        // Also: The password should be hashed
        tap(User::whereName('my-name')->firstOrFail(), function ($user) {
            $this->assertTrue(Hash::check('secret', $user->password));

            // And: A random token should be generated
            $this->assertNotNull($user->token);
        });

    }

    /** @test */
    public function a_username_must_be_passed_to_create_a_user()
    {
        try {
            $this->artisan('create:user', ['--no-interaction' => true]);
        } catch(\Exception $e) {
            return;
        }

        $this->fail('Exception not thrown');
    }
}
