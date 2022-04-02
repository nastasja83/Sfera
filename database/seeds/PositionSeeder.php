<?php

use Illuminate\Database\Seeder;
use App\Position;

class PositionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $positions = ['Администратор', 'Менеджер', 'Офис-менеджер'];

        foreach ($positions as $position) {
            $newPosition = new Position();
            $newPosition->fill(['position_name' => $position]);
            $newPosition->save();
        }
    }
}
