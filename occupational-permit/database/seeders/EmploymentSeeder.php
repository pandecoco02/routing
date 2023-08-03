<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmploymentType;
class EmploymentSeeder extends Seeder
{

    public function run(): void
    {
        $types = [
            [
                'name' => 'Programmer',
                'slug' => config('enums.types.programmer'),
            ],
        ];

        EmploymentType::insert($types);
    }
}
