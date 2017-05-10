<?php

namespace InvisibleMan\Geo\Services\Google\API;

use InvisibleMan\Geo\Location\Geopoint;
use InvisibleMan\Geo\Services\Google\GoogleMapsAPI;

/**
 * Class Timezone
 * @package     InvisibleMan\Geo\Services\Google\API
 * @author      Carlos Granados <granados.carlos91@gmail.com>
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