<?php

namespace InvisibleMan\Geo\Support;

use GuzzleHttp\Client;
use Illuminate\Cache\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\DatabaseManager;
use InvisibleMan\Geo\Services\GeocodeManager;
use InvisibleMan\Geo\Services\Google\API\Geocode;
use InvisibleMan\Geo\Services\Google\API\Timezone;
use InvisibleMan\Geo\Contracts\GeoServiceInterface;
use InvisibleMan\Geo\Services\Google\API\Directions;

/**
 * Class GeoServiceProvider
 *
 * @package InvisibleMan\Geo\Support
 * @author  Carlos Granados <granados.carlos91@gmail.com>
 */
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
