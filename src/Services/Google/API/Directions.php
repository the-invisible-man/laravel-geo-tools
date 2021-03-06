<?php

namespace InvisibleMan\Geo\Services\Google\API;

use InvisibleMan\Geo\Services\Google\GoogleMapsAPI;

/**
 * Class Directions
 * @package     InvisibleMan\Geo\Services\Google\Services
 * @author      Carlos Granados <granados.carlos91@gmail.com>
 * */
class Directions extends GoogleMapsAPI {

    const   DRIVING     = 'driving',
            WALKING     = 'walking',
            TRANSIT     = 'transit',
            BICYCLING   = 'bicycling',

            AS_MINUTES  = 'value',
            AS_STRING   = 'text';

    /**
     * @param string $origin
     * @param string $destination
     * @param string $travelMode
     * @return array
     */
    public function getDirections(string $origin, string $destination, string $travelMode = Directions::DRIVING) : array
    {
        $data = [
            'origin'        => $origin,
            'destination'   => $destination,
            'travelMode'    => $travelMode
        ];

        return $this->do($data);
    }
    /**
     * @return string
     */
    protected function getOutput(): string
    {
        return '/'.$this->getConfig('response');
    }
}
