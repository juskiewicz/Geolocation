<?php
namespace Juskiewicz\Geolocation\Model;

use Juskiewicz\Geolocation\Model\AddressInterface;
use Juskiewicz\Geolocation\Model\Coordinates;

class Address implements AddressInterface
{
    /**
     * @var Coordinates|null
     */
    private $coordinates;

    /**
     * @var string|null
     */
    private $streetName;

    /**
     * @var string|int|null
     */
    private $streetNumber;

    /**
     * @var string|null
     */
    private $locality;

    /**
     * @var string|null
     */
    private $postalCode;

    /**
     * @var string|null
     */
    private $country;

    /**
     * @var string|null
     */
    private $countryCode;

    /**
     * @param Coordinates|null  $coordinates
     * @param string|null       $streetName
     * @param string|null       $streetNumber
     * @param string|null       $locality
     * @param string|null       $postalCode
     * @param string|null       $country
     * @param string|null       $countryCode
     */
    public function __construct(
        Coordinates $coordinates = null,
        string $streetName = null,
        string $streetNumber = null,
        string $postalCode = null,
        string $locality = null,
        string $country = null,
        string $countryCode = null
    ) {
        $this->coordinates = $coordinates;
        $this->streetName = $streetName;
        $this->streetNumber = $streetNumber;
        $this->postalCode = $postalCode;
        $this->locality = $locality;
        $this->country = $country;
        $this->countryCode = $countryCode;
    }

    /**
     * @return Coordinates|null
     */
    public function getCoordinates() : Coordinates
    {
        return $this->coordinates;
    }

    /**
     * @param   CoordinatesInterface $coordinates
     * @return  self
     */
    public function setCoordinates(CoordinatesInterface $coordinates) : self
    {
        $this->coordinates = $coordinates;
        return $this;
    }

    /**
     * @return  string|null
     */
    public function getStreetName() : string
    {
        return $this->streetName;
    }

    /**
     * @param   string  $streetName
     * @return  self
     */
    public function setStreetName(string $streetName) : self
    {
        $this->streetName = $streetName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreetNumber() : string
    {
        return $this->streetNumber;
    }

    /**
     * @param   string  $streetNumber
     * @return  self
     */
    public function setStreetNumber(string $streetNumber) : self
    {
        $this->streetNumber = $streetNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLocality() : string
    {
        return $this->locality;
    }

    /**
     * @param   string  $locality
     * @return  self
     */
    public function setLocality(string $locality) : self
    {
        $this->locality = $locality;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostalCode() : string
    {
        return $this->postalCode;
    }

    /**
     * @param   string  $postalCode
     * @return  self
     */
    public function setPostalCode(string $postalCode) : self
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry() : string
    {
        return $this->country;
    }

    /**
     * @param   string  $country
     * @return  self
     */
    public function setCountry(string $country) : self
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountryCode() : string
    {
        return $this->countryCode;
    }

    /**
     * @param   string  $countryCode
     * @return  self
     */
    public function setCountryCode(string $countryCode) : self
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFormattedAddress()
    {
        /** @var string|null $formattedAddress */
        $formattedAddress = null;

        // add street name and number
        if (!is_null($this->getStreetName()) && !is_null($this->getStreetNumber())) {
            $fullStreet = $this->getStreetName().' '.$this->getStreetNumber();
            $formattedAddress = sprintf('%s%s', $formattedAddress, $fullStreet);
        } elseif (!is_null($this->getStreetName())) {
            $formattedAddress = sprintf('%s %s', $formattedAddress, $this->getStreetNumber());
        }

        // add postal code and locality
        if (!is_null($this->getPostalCode()) && !is_null($this->getLocality())) {
            $fullLocality = $this->getPostalCode().' '.$this->getLocality();
            $formattedAddress = sprintf('%s, %s', $formattedAddress, $fullLocality);
        } elseif (!is_null($this->getPostalCode())) {
            $formattedAddress = sprintf('%s, %s', $formattedAddress, $this->getLocality());
        }

        // add country
        if (!is_null($this->getCountry())) {
            $formattedAddress = sprintf('%s, %s', $formattedAddress, $this->getCountry());
        }

        return $formattedAddress;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        // set coordinates
        $latitude = null;
        $longitude = null;
        $coordinates = $this->getCoordinates();
        if (null !== $coordinates) {
            $latitude = $coordinates->getLatitude();
            $longitude = $coordinates->getLongitude();
        }

        return [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'streetNumber' => $this->streetNumber,
            'streetName' => $this->streetName,
            'postalCode' => $this->postalCode,
            'locality' => $this->locality,
            'country' => $this->country,
            'countryCode' => $this->countryCode,
            'formattedAddress' => $this->getFormattedAddress()
        ];
    }
}