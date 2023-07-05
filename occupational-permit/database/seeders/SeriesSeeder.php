<?php

namespace Database\Seeders;

use App\Models\Series;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use DB;

class SeriesSeeder extends Seeder
{
    public function run()
    {
        DB::table('series')->delete();
        Series::create(array(
            'name' => 'Occupation Permit',
            'slug' => 'occupational-permit',
            'prefix' => 'JD',
            'max_digit' => 6,
            'starting_value' => 1
        )); 
    }
}
