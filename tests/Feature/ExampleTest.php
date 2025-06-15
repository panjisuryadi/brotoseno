<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\RefreshTestDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshTestDatabase, DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        Artisan::call('migrate');
        $this->seed();
        $this->withoutExceptionHandling();
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
