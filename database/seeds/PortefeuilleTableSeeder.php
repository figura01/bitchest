<?php

use Illuminate\Database\Seeder;

class PortefeuilleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Portefeuille::class, 7)->create();
    }
}
