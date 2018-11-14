<?php
namespace Juskiewicz\Geolocation\Model;

class Coordinates implements CoordinatesInterface
{
    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getLatitude() : float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude() : float
    {
        return $this->longitude;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude()
        ];
    }
}