<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Club;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Club::create([
            'club_name' => 'Kelab Kejuruteraan Elektrik (KKE)',
            'description' => 'Kelab Kejuruteraan Elektrik (abbreviated as KKE) or Club of Electrical Engineering was founded with the aim of becoming an establishment that is both trustworthy and referred to by both students and staff of FKEE.',
            'user_id' => 1,
        ]);

        Club::create([
            'club_name' => 'ITC Club UTHM',
            'description' => 'Club under Faculty of Computer Science and Information Technology',
            'user_id' => 2,
        ]);
    }
}

