<?php

namespace InvisibleMan\Geo\Contracts;

use Combustion\Geo\Location\Geopoint;
use Combustion\Geo\Responses\GeocodeResponse;
use Combustion\Geo\Responses\TimeZoneResponse;
use Combustion\Geo\Services\Google\API\Directions;

/**
 * Interface GeoServiceInterface
 *
 * @package InvisibleMan\Geo\Contracts
 * @author Carlos Granados <granados.carlos91@gmail.com>
 */
interface GeoServiceInterface {

    /**
     * Expected to return duration in minutes - I know I shouldn't use the Directions class
     * from the Google API package, but I have little time now.
     *
     * Todo: Fix that shit
     * @param string $startingZip
     * @param string $destinationZip
     * @param string $format
     * @param string $travelMode
     * @return string|int
     */
    public function estimateTripDurationByZip(string $startingZip, string $destinationZip, string $format = Directions::AS_MINUTES, string $travelMode = Directions::DRIVING);

    /**
     * @param string $address
     * @return GeocodeResponse
     */
    public function geocode(string $address) : GeocodeResponse;

    /**
     * @param Geopoint $geopoint
     * @param int $timestamp
     * @return TimeZoneResponse
     */
    public function getTimeZone(Geopoint $geopoint, int $timestamp = null) : TimeZoneResponse;
}
