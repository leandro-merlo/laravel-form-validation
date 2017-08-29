<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Client::class, function (Faker\Generator $faker) {

    return [
        'telefone' => $faker->phoneNumber,
        'inadimplente' => rand(0, 1),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Client::class, 'pessoa_fisica', function (Faker\Generator $faker) {
    return [
        'nome' => $faker->name,
        'email' => $faker->email,
        'documento' => $faker->cpf,
        'data_nasc' => $faker->date,
        'estado_civil' => rand(1,3),
        'sexo' => rand(1,10) % 2 == 0 ? 'm' : 'f',
        'deficiencia' => $faker->word,
        'pessoa' => \App\Client::PESSOA_FISICA
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Client::class, 'pessoa_juridica', function (Faker\Generator $faker) {
    return [
        'nome' => $faker->company,
        'email' => $faker->companyEmail,
        'documento' => $faker->cnpj,
        'fantasia' => $faker->companySuffix . ' ' . $faker->word,
        'pessoa' => \App\Client::PESSOA_JURIDICA
    ];
});