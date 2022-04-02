<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Position;
use App\Skill;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $position = Position::where('position_name', 'Администратор')->first();
        $skills = Skill::whereIn('id', [1, 2, 3])->get();

        $data = [
            'last_name' => 'testAdmin',
            'first_name' => 'testAdmin',
            'middle_name' => 'testAdmin',
            'position_id' => $position->id,
            'email' => 'admin@example.com',
            'is_admin' => true,
            'phone' => '+79999999999',
            'email_verified_at' => now(),
            'password' => bcrypt('adminadmin'),
            'remember_token' => Str::random(10),
        ];
        $admin = new User();
        $admin->fill($data)->save();
        $admin->skills()->attach($skills);
    }
}
