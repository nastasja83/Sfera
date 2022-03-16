<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomePageTest extends TestCase
{
    /**
     * Test of welcome page accessibility.
     *
     * @return void
     */
    public function testWelcome(): void
    {
        $response = $this->get(route('welcome'));

        $response->assertOk();
        $response->assertSee('Данные сотрудников');
    }
}
