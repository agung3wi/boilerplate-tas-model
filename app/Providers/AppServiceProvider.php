<?php

namespace App\Providers;

use App\CoreService\CallService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Route::middleware(['web', 'setguard:web'])->group(function () {

            foreach (Config::get("service") as $route) {
                $reflect = new \ReflectionClass($route["class"]);
                $serviceName = $reflect->getShortName();
                $this->app->singleton($serviceName, $route["class"]);
                if (!isset($route["end_point"]) && !isset($route["type"])) continue;

                if ($route["type"] == "POST") {
                    Route::post($route["end_point"], function () use ($serviceName) {
                        $input = request()->all();
                        return CallService::execute($serviceName, $input);
                    });
                } else if ($route["type"] == "GET") {
                    Route::get($route["end_point"], function () use ($serviceName) {
                        $input = request()->all();
                        return CallService::execute($serviceName, $input);
                    });
                }
            };
        });
        require __DIR__ . "../../helpers/function.php";
    }
}
