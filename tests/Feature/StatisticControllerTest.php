<?php

namespace Tests\Feature;

use Tests\TestCase;

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
