<?php

namespace Tests\Feature;

use Tests\TestCase;

final class ExampleTest extends TestCase
{
    /**
     * @return void
     */
    public function testBasicTest(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
