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

        // Panggil seeder yang ingin Anda jalankan di sini
        $this->call([
        CountriesTableSeeder::class,
        StatesTableSeeder::class,
        CitiesTableSeeder::class]);
    }
}