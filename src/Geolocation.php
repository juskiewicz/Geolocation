<?php
namespace Juskiewicz\Geolocation;

use Juskiewicz\Geolocation\Build\{
    AddressBuild,
    CoordinatesBuild
};
use Juskiewicz\Geolocation\Http\AbstractHttp;
use Juskiewicz\Geolocation\Model\{
    AddressCollection,
    AddressInterface,
    CoordinatesInterface
};

class Geolocation extends AbstractHttp
{
    /**
     * @var string
     */
    const API_ADDRESS_URL_SSL = 'https://maps.googleapis.com/maps/api/geocode/json?address=%s';

    /**
     * @var string
     */
    const API_COORDINATES_URL_SSL = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=%F,%F';

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string|null
     */
    private $region;

    /**
     * @var string|null
     */
    private $locale;

    public function __construct(string $apiKey, ?string $region, ?string $locale)
    {
        $this->apiKey = $apiKey;
        $this->region = $region;
        $this->locale = $locale;
        parent::__construct();
    }

    /**
     * Get address using CoordinatesInterface
     *
     * @param  CoordinatesInterface $coordinates
     * @return AddressInterface
     */
    public function getAddress(CoordinatesInterface $coordinates) : AddressInterface
    {
        $addresses = $this->getAddresses($coordinates);

        return $addresses[0];
    }

    /**
     * Get possible addresses using CoordinatesInterface
     *
     * @param CoordinatesInterface $coordinates
     * @return AddressCollection
     */
    public function getAddresses(CoordinatesInterface $coordinates) : AddressCollection
    {
        $url = $this->coordinatesQuery($coordinates);
        $json = $this->fetchUrl($url);

        // convert google data to address collection
        $results = [];
        foreach ($json->results as $result) {
            $address = AddressBuild::create($result);
            $address->setCoordinates($coordinates);
            $results[] = $address;
        }

        return new AddressCollection($results);
    }

    /**
     * Get coordinates using AddressInterface
     *
     * @param AddressInterface $address
     * @return CoordinatesInterface
     */
    public function getCoordinates(AddressInterface $address) : CoordinatesInterface
    {
        $url = $this->addressQuery($address);
        $json = $this->fetchUrl($url);

        // convert google data to coordinates
        $coordinates = CoordinatesBuild::create($json->results[0]);

        return $coordinates;
    }

    /**
     * @param CoordinatesInterface $coordinates
     * @return string
     */
    private function coordinatesQuery(CoordinatesInterface $coordinates) : string
    {
        $url = sprintf(self::API_COORDINATES_URL_SSL, $coordinates->getLatitude(), $coordinates->getLongitude());
        $url = $this->buildQuery($url, $this->apiKey, $this->locale, $this->region);

        return $url;
    }

    /**
     * @param AddressInterface $address
     * @return string
     */
    private function addressQuery(AddressInterface $address) : string
    {
        $url = sprintf(self::API_ADDRESS_URL_SSL, rawurlencode($address->getFormattedAddress()));
        $url = $this->buildQuery($url, $this->apiKey, $this->locale, $this->region);

        return $url;
    }

    /**
     * build query with extra params
     *
     * @param string $url
     * @param string $locale
     * @param string $region
     * @param string $apiKey
     *
     * @return string
     */
    private function buildQuery(string $url, string $apiKey, string $locale = null, string $region = null) : string
    {
        if (null !== $apiKey) {
            $url = sprintf('%s&key=%s', $url, $apiKey);
        }
        if (null !== $locale) {
            $url = sprintf('%s&language=%s', $url, $locale);
        }
        if (null !== $region) {
            $url = sprintf('%s&region=%s', $url, $region);
        }

        return $url;
    }

    /**
     * @param string $url
     * @return object
     */
    private function fetchUrl(string $url) : object
    {
        $content = $this->getUrlContents($url);
        $json = $this->validateResponse($url, $content);

        return $json;
    }
}