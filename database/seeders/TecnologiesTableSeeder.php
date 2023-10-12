<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TecnologiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technologies = ['Vue', 'React', 'JS', 'TS', 'CSS', "SCSS", "Bootstrap", "Tailwind", "PHP", "Laravel", "NodeJs"];

        foreach ($technologies as $technology) {
            Technology::create([
                'name' => $technology,
            ]);
        }
    }
}
