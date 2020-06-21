<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 50)->create();
        factory(App\Treatment_type::class, 50)->create();
        factory(App\Treatment_Price::class, 50)->create();
        factory(App\Transact::class, 100)->create();
        factory(App\Detail_Transact::class, 100)->create();
    }
}
