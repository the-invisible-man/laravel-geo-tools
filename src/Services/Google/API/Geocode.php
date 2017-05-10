<?php

namespace Combustion\Geo\Services\Google\API;

use Combustion\Geo\Services\Google\GoogleMapsAPI;

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
