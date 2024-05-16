<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'is_admin' => true
        ]);
        
        $this->call([
        CountriesTableSeeder::class,
        StatesTableSeeder::class,
        CitiesTableSeeder::class]);
    }
}