<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Signatory;

class SignatorySeeder extends Seeder
{
    public function run(): void
    {
        $signatory = new Signatory();
        $signatory -> LastName = 'Valdehuesa';
        $signatory -> FirstName ='Peter';
        $signatory -> Position ='Cantonist I';
        $signatory -> DivisionName='CSD';
        $signatory -> OfficeName='CSD';
        $signatory -> City='Zamboanga City';
        $signatory->save();
    }
}
