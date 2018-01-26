<?php

use Illuminate\Database\Seeder;

class CoursmonnaieTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        function getCotationFor($cryptoname){
            return ((rand(0, 99)>40) ? 1 : -1) * ((rand(0, 99)>49) ? ord(substr($cryptoname,0,1)) : ord(substr($cryptoname,-1))) * (rand(1,10) * .01);
        }
        $cryptos = App\Crypto::all();

        foreach ($cryptos as $crypto)
        {
            $crypto_base = $crypto->valeur_init;

            for ($j = 0; $j < 30; $j++)
            {
                $date = new DateTime();

                $coursmonnaie = factory(App\Coursmonnaie::class, 1)->create();
                $cryptoname = $crypto->name;
                $crypto_base +=  ((rand(0, 99)>40) ? 1 : -1) * ((rand(0, 99)>49) ? ord(substr($cryptoname,0,1)) : ord(substr($cryptoname,-1))) * (rand(1,10) * .01);
;
                if ($crypto_base < 0 )  $crypto_base = 0;

                $coursmonnaie[0]->taux = $crypto_base;
                $coursmonnaie[0]->date = $date->modify('-'.(29 - $j).'days')->format('Y-m-d');
                $crypto->coursmonnaie()->save($coursmonnaie[0]);

                }
        };
    }

}
