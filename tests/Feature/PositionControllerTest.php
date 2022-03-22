<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Position;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PositionControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = factory(User::class)->create([
            'is_admin' => true,
        ]);
    }

    /**
     * Test of positions index.
     *
     * @return void
     */
    public function testIndex(): void
    {
        $response = $this->get(route('positions.index'));
        $response->assertOk();
    }
    //     /**
    //  * Test of positions create.
    //  *
    //  * @return void
    //  */
    // public function testCreate(): void
    // {
    //     $response = $this->actingAs($this->admin)
    //         ->get(route('positions.create'));
    //     $response->assertOk();
    // }

    // /**
    //  * Test of positions store.
    //  *
    //  * @return void
    //  */
    // public function testStore(): void
    // {
    //     $positionInputData = factory(Position::class)
    //     ->make()
    //     ->only(['position_name']);

    //     $response = $this->actingAs($this->admin)
    //         ->post(route('positions.store', $positionInputData));
    //     $response->assertSessionHasNoErrors();
    //     $response->assertRedirect(route('positions.index'));
    //     $this->get(route('positions.index'))->assertSee($positionInputData['position_name']);
    //     $this->assertDatabaseHas('positions', $positionInputData);
    // }

    // /**
    //  * Test of positions update.
    //  *
    //  * @return void
    //  */
    // public function testUpdate(): void
    // {
    //     $position = factory(Position::class)->create();

    //     $positionInputData = factory(Position::class)
    //     ->make()
    //     ->only(['position_name']);
    //     $response = $this->actingAs($this->admin)
    //         ->patch(route('positions.update', ['position' => $position]), $positionInputData);
    //     $response->assertSessionHasNoErrors();
    //     $response->assertRedirect(route('positions.index'));
    //     $this->get(route('positions.index'))->assertSee($positionInputData['position_name']);
    //     $this->assertDatabaseHas('positions', $positionInputData);
    // }

    // /**
    //  * Test of positions delete.
    //  *
    //  * @return void
    //  */
    // public function testDestroy(): void
    // {
    //     $position = factory(Position::class)->create();
    //     $response = $this->actingAs($this->admin)
    //         ->delete(route('positions.destroy', ['position' => $position]));
    //     $response->assertSessionHasNoErrors();
    //     $response->assertRedirect(route('positions.index'));
    //     $this->assertDatabaseMissing('positions', ['id' => $position->id]);
    // }

}
