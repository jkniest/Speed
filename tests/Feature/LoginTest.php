<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_login()
    {
        // Given: A user exists in the database
        $user = $this->create(\App\User::class);

        $this->assertFalse(auth()->check());

        // When: This user tries to login
        $response = $this->post('/login', [
            'name'     => $user->name,
            'password' => 'secret'
        ]);

        // Then: The user should be signed in
        $this->assertTrue(auth()->check());

        // And: The user should be redirected to the overview page
        $response->assertRedirect('/overview');
    }

    /** @test */
    public function a_user_must_submit_a_name_to_login()
    {
        $this->withExceptionHandling();

        // When: Someone tries to login without submitting a name
        $response = $this->post('/login', [
            'password' => 'secret'
        ]);

        // Then: The user should not be signed in
        $this->assertFalse(auth()->check());

        // And: The response should contain an error related to 'name'
        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function a_user_must_submit_a_password_to_login()
    {
        $this->withExceptionHandling();

        // When: Someone tries to login without submitting a password
        $response = $this->post('/login', [
            'username' => 'someone'
        ]);

        // Then: The user should not be signed in
        $this->assertFalse(auth()->check());

        // And: The response should contain an error related to 'password'
        $response->assertSessionHasErrors(['password']);
    }
}
