<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatisticControllerTest extends TestCase
{
    /**
     * Test of statistic index.
     *
     * @return void
     */
    public function testIndex(): void
    {
        $response = $this->get(route('statistic.index'));
        $response->assertOk();
    }
}
