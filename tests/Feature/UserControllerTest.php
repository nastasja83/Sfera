<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /**
     * Test of tasks index.
     *
     * @return void
     */
    public function testIndex(): void
    {
        $response = $this->get(route('users.index'));
        $response->assertOk();
    }

    /**
     * Test of tasks edit.
     *
     * @return void
     */
    public function testEdit(): void
    {
        $task = factory(User::class)->create();
        $response = $this->actingAs($this->user)
            ->get(route('users.edit', ['user' => $task]));
        $response->assertOk();
    }

    /**
     * Test of tasks update.
     *
     * @return void
     */
    public function testUpdate(): void
    {
        $currentUser = factory(User::class)->create();
        $updatedUser = factory(User::class)
            ->make()
            ->only(['last_name','first_name', 'middle_name', 'position_id', 'email', 'phone']);

        $response = $this->actingAs($this->user)
            ->patch(route('users.update', ['users' => $currentUser]), $updatedUser);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('users.index'));

        $response = $this->get(route('users.index'));
        $this->assertDatabaseHas('users', $updatedUser);
    }

    /**
     * Test of tasks delete.
     *
     * @return void
     */
    public function testDestroy(): void
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($this->user)
            ->delete(route('users.destroy', ['user' => $user]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('users.index'));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
