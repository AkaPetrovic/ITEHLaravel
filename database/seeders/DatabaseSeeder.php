<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Car;
use App\Models\Manufacturer;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        Car::truncate();
        User::truncate();
        Manufacturer::truncate();

        Schema::enableForeignKeyConstraints();

        User::factory(10)->create();
        Manufacturer::factory(3)->create();
        Car::factory(10)->create();
    }
}
