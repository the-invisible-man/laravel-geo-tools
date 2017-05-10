<?php

namespace Combustion\Geo\Support;

use Combustion\Geo\Services\Google\API\Places;
use Combustion\Geo\Services\Google\API\PlaceSearch;
use GuzzleHttp\Client;
use Combustion\Geo\GeoGateway;
use Illuminate\Cache\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\DatabaseManager;
use Combustion\Geo\Services\GeocodeManager;
use Combustion\Geo\Services\Google\API\Geocode;
use Combustion\Geo\Services\Google\API\Timezone;
use Combustion\Geo\Contracts\GeoServiceInterface;
use Combustion\Geo\Services\Google\API\Directions;

class GeoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(GeocodeManager::class, function (Application $app) {
            return new GeocodeManager($app);
        });

        $this->app->singleton(GeoServiceInterface::class, function (Application $app) {
            return $app[GeocodeManager::class]->service();
        });

        $this->app->singleton(Directions::class, function (Application $app) {
            $config             = $app['config']['geo.drivers.google.directions-api'];
            $config['apiKey']   = $app['config']['geo.drivers.google.key'];
            $httpClient         = new Client();

            return new Directions($config, $httpClient);
        });

        $this->app->singleton(Geocode::class, function (Application $app) {
            $config             = $app['config']['geo.drivers.google.geocode-api'];
            $config['apiKey']   = $app['config']['geo.drivers.google.key'];
            $httpClient         = new Client();

            return new Geocode($config, $httpClient);
        });

        $this->app->singleton(Timezone::class, function (Application $app) {
            $config             = $app['config']['geo.drivers.google.timezone-api'];
            $config['apiKey']   = $app['config']['geo.drivers.google.key'];
            $httpClient         = new Client();

            return new Timezone($config, $httpClient);
        });
    }
}
