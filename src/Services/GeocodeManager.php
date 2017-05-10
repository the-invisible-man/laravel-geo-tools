<?php

namespace InvisibleMan\Geo\Services;

use InvisibleMan\Geo\Support\ServiceManager;
use InvisibleMan\Geo\Contracts\ServiceFactory;

/**
 * Class GeocodeManager
 * @package     InvisibleMan\Geo\API
 * @author      Carlos Granados <granados.carlos91@gmail.com>
 */
class GeocodeManager extends ServiceManager implements ServiceFactory
{
    /**
     * Get the cache connection configuration.
     *
     * @param  string  $name
     * @return string
     */
    protected function getConfig(string $name)
    {
        return $this->app['config']["cache.stores.{$name}"];
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function service(string $name = null)
    {
        $name = $name ?: $this->getDefaultService();

        return $this->app[$name];
    }

    /**
     * Get the default cache driver name.
     *
     * @return string
     */
    public function getDefaultService() : string
    {
        return $this->app['config']['geo.default'];
    }
}
