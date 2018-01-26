<?php

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
        $this->call(UsersTableSeeder::class);
        $this->call(CryptoTableSeeder::class);
        $this->call(PortefeuilleTableSeeder::class);
        $this->call(CoursmonnaieTableSeeder::class);
        $this->call(SpendsTableSeeder::class);

    }
}
