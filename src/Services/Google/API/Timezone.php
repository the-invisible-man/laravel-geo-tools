<?php

namespace Combustion\Geo\Services\Google\API;

use Combustion\Geo\Location\Geopoint;
use Combustion\Geo\Services\Google\GoogleMapsAPI;

/**
 * Class Timezone
 * @package     Combustion\Geo\Services\Google\API
 * @author      Carlos Granados <cgranados@combustiongroup.com>
 */
class Timezone extends GoogleMapsAPI
{
    /**
     * Resolves timezone by lat long
     * @param Geopoint $geopoint
     * @param int $timestamp
     * @return string
     */
    public function resolveTimezone(Geopoint $geopoint, int $timestamp = null)
    {
        $data = [
            'location'  => $geopoint->getLat() . ", " . $geopoint->getLong(),
            'timestamp' => is_null($timestamp) ? time() : $timestamp
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