<?php

namespace App\Providers;

use App\Client;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\ServiceProvider;
use Insight\Utils\ValidarStrings;
use JansenFelipe\FakerBR\FakerBR;
use Symfony\Component\HttpKernel\Tests\ClientTest;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('documento', function($attribute, $value, $parameters = [], $validador){
            if ($parameters[0] == 'cpf'):
                return ValidarStrings::validarCpf($value);
            else:
                return ValidarStrings::validarCnpj($value);
            endif;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->singleton(\Faker\Generator::class, function(){
                $faker = Factory::create(env('FAKER_LANGUAGE'));
                $faker->addProvider(new FakerBR($faker));
                return $faker;
            });
        }
    }
}
