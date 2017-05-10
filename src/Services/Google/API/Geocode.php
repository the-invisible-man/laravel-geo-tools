<?php

namespace InvisibleMan\Geo\Services\Google\API;

use InvisibleMan\Geo\Services\Google\GoogleMapsAPI;

/**
 * Class Geocode
 *
 * @package InvisibleMan\Geo\Services\Google\API
 * @author Carlos Granados <granados.carlos91@gmail.com>
 */
class Geocode extends GoogleMapsAPI
{
    /**
     * @param string $address
     * @return array
     */
    public function geocode(string $address) : array
    {
        $data = [
            'address' => $address
        ];

        return $this->do($data);
    }

    /**
     * @return string
     */
    protected function getOutput(): string
    {
        return '/' . $this->getConfig('response');
    }
}
