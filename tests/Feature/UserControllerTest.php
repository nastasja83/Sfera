<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

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
        $admin = factory(User::class)->make([
            'is_admin' => true,
        ]);
        $response = $this->actingAs($this->user)
            ->get(route('users.edit', ['user' => $this->user]));
        $response->assertOk();

        $response = $this->actingAs($admin)
            ->get(route('users.edit', ['user' => $this->user]));
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
            ->only(['last_name', 'first_name', 'middle_name', 'position_id', 'email', 'phone']);
        $response = $this->actingAs($this->user)
            ->patch(route('users.update', ['user' => $currentUser]), $updatedUser);
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
        $admin = factory(User::class)->make([
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('users.destroy', ['user' => $this->user]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('users.index'));

        $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
    }
}
