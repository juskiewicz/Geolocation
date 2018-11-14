<?php
namespace Juskiewicz\Geolocation\Model;

interface CoordinatesInterface
{
    /**
     * @return float
     */
    public function getLatitude();

    /**
     * @return float
     */
    public function getLongitude();

    /**
     * @return array
     */
    public function toArray(): array;
}