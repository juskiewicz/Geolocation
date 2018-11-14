<?php
namespace Juskiewicz\Geolocation\Build;

use Juskiewicz\Geolocation\Model\Coordinates;

class CoordinatesBuild
{
    /**
     * @var object
     */
    private $googleData;

    /**
     * create address from google maps api result
     *
     * @param object $googleData Google single result
     * @return Coordinates
     */
    public static function create(object $googleData) : Coordinates
    {
        $build = new self($googleData);
        $address = $build->createCoordinatesFromGeometry();

        return $address;
    }

    /**
     * @param object $googleData Google single result
     */
    public function __construct(object $googleData)
    {
        $this->googleData = $googleData;
    }

    /**
     * create address from google address components
     *
     * @return Coordinates
     */
    public function createCoordinatesFromGeometry() : Coordinates
    {
        // create new coordinates object
        $coordinates = new Coordinates($this->googleData->geometry->location->lat, $this->googleData->geometry->location->lng);

        return $coordinates;
    }
}