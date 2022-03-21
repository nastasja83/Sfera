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
        /**
     * Test of skills create.
     *
     * @return void
     */
    public function testCreate(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('skills.create'));
        $response->assertOk();
    }

    /**
     * Test of skills edit.
     *
     * @return void
     */
    public function testEdit(): void
    {
        $skill = factory(Skill::class)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('skills.edit', ['skill' => $skill]));
        $response->assertOk();
    }

    /**
     * Test of skills store.
     *
     * @return void
     */
    public function testStore(): void
    {
        $skillInputData = factory(Skill::class)
        ->make()
        ->only(['skill_name']);

        $response = $this->actingAs($this->admin)
            ->post(route('skills.store', $skillInputData));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('skills.index'));
        $this->get(route('skills.index'))->assertSee($skillInputData['skill_name']);
        $this->assertDatabaseHas('skills', $skillInputData);
    }

    /**
     * Test of skills update.
     *
     * @return void
     */
    public function testUpdate(): void
    {
        $skill = factory(Skill::class)->create();

        $skillInputData = factory(Skill::class)
        ->make()
        ->only(['skill_name']);

        $response = $this->actingAs($this->admin)
            ->patch(route('skills.update', ['skill' => $skill]), $skillInputData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('skills.index'));
        $this->get(route('skills.index'))->assertSee($skillInputData['skill_name']);
        $this->assertDatabaseHas('skills', $skillInputData);
    }

    /**
     * Test of skills delete.
     *
     * @return void
     */
    public function testDestroy(): void
    {
        $skill = factory(Skill::class)->create();
        $response = $this->actingAs($this->admin)
            ->delete(route('skills.destroy', ['skill' => $skill]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('skills.index'));
        $this->assertDatabaseMissing('skills', ['id' => $skill->id]);
    }
}
