<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PageTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function index_unauthenticated()
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function index_authenticated()
    {
        $this->signIn();

        $response = $this->get('/');

        $response->assertRedirect('/overview');
    }

    /** @test */
    public function login_unauthenticated()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /** @test */
    public function login_authenticated()
    {
        $this->signIn();

        $response = $this->get('/login');

        $response->assertRedirect('/overview');
    }

    /** @test */
    public function overview_unauthenticated()
    {
        $this->withExceptionHandling();

        $response = $this->get('/overview');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function overview_authenticated()
    {
        $this->signIn();

        $response = $this->get('/overview');

        $response->assertStatus(200);
    }
}
