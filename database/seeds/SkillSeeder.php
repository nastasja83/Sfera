<?php

use Illuminate\Database\Seeder;
use App\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $skills = ['Креативность', 'Клиентоориентированность', 'Управление людьми'];

        foreach ($skills as $skill) {
            $newSkill = new Skill();
            $newSkill->fill(['skill_name' => $skill]);
            $newSkill->save();
        }
    }
}
