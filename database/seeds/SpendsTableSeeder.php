<?php



use Illuminate\Database\Seeder;

class SpendsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::all();

        factory(App\Spend::class, 10)->create()->each(function($spend) use($users){

            $user = $users[rand(0,count($users) - 1)];

            $spend->user()->associate($user);

            $spend->save();
        });
    }
}
