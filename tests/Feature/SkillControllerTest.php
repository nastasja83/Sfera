<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Skill;
use App\User;

class SkillControllerTest extends TestCase
{
    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = factory(User::class)->create([
            'is_admin' => true,
        ]);
    }

    /**
     * Test of skills index.
     *
     * @return void
     */
    public function testIndex(): void
    {
        $response = $this->get(route('skills.index'));
        $response->assertOk();
    }
}
