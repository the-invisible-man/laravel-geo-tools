<?php

namespace Combustion\Geo\Services\Google\API;

use Combustion\Geo\Services\Google\GoogleMapsAPI;

/**
 * Class Directions
 * @package     Combustion\Geo\Services\Google\Services
 * @author      Carlos Granados <cgranados@combustiongroup.com>
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
