<?php

namespace Tests\Feature;

use Tests\TestCase;

class BuildTest extends TestCase
{
    /**
     * A basic test example.
     * Ensures the app deployed and built successfully.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
