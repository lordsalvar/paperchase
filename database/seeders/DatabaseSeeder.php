<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvent;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $office = \App\Models\Office::firstOrCreate([
            'name' => 'Default Office',
            'acronym' => 'DO',
            'head_name' => 'John Doe',
            'designation' => 'Manager',
        ]);

        \App\Models\User::factory(10)->create([
            'office_id' => $office->id,
        ]);
    }
}
