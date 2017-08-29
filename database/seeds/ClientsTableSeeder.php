<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Client::class, rand(30,120))->states('pessoa_juridica')->create();
        factory(\App\Client::class, rand(30,120))->states('pessoa_fisica')->create();
    }
}
