<?php

namespace Tests;

use App\Exceptions\Handler;
use App\User;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Disable exception handling as an additional setup step
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->disableExceptionHandling();
    }

    /**
     * Wrapper for factory()->create
     *
     * @param mixed $class      The class that should be created
     * @param array $attributes Additional attributes
     *
     * @return mixed
     */
    protected function create($class, $attributes = [])
    {
        return factory($class)->create($attributes);
    }

    /**
     * Wrapper for factory()->make
     *
     * @param mixed $class      The class that should be made
     * @param array $attributes Additional attributes
     *
     * @return mixed
     */
    protected function make($class, $attributes = [])
    {
        return factory($class)->make($attributes);
    }

    /**
     * Disable the internal exception handling and throw all exceptions
     * instead.
     *
     * @return $this
     */
    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class, new class extends Handler
        {
            public function __construct()
            {
            }

            public function report(\Exception $e)
            {
            }

            public function render($request, \Exception $e)
            {
                throw $e;
            }
        });

        return $this;
    }

    /**
     * Enable the default exception handler again
     *
     * @return $this
     */
    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);

        return $this;
    }

    protected function signIn(int $userId = 0)
    {
        if ($userId == 0) {
            return tap($this->create(\App\User::class), function ($user) {
                $this->actingAs($user);
            });
        }

        return tap(User::findOrFail($userId), function ($user) {
            $this->actingAs($user);
        });
    }
}
