<?php
namespace Juskiewicz\Geolocation\Model;

interface AddressInterface
{
    /**
     * @return string|null
     */
    public function getStreetName();

    /**
     * @return string|null
     */
    public function getStreetNumber();

    /**
     * @return string|null
     */
    public function getPostalCode();

    /**
     * @return string|null
     */
    public function getLocality();

    /**
     * @return string|null
     */
    public function getCountry();

    /**
     * @return Coordinates|null
     */
    public function getCoordinates();

    /**
     * @return string|null
     */
    public function getFormattedAddress();

    /**
     * @return array
     */
    public function toArray(): array;
}