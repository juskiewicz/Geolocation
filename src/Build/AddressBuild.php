<?php
namespace Juskiewicz\Geolocation\Build;

use Juskiewicz\Geolocation\Model\Address;

class AddressBuild
{
    /**
     * @var object
     */
    private $googleData;

    /**
     * create address from google maps api result
     *
     * @param object $googleData Google single result
     * @return Address
     */
    public static function create(object $googleData) : Address
    {
        $build = new self($googleData);
        $address = $build->createAddressFromComponents();

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
     * @return Address
     */
    public function createAddressFromComponents() : Address
    {
        // create new address object
        $address = new Address();

        // update address from google address components
        foreach ($this->googleData->address_components as $component) {
            $this->updateAddressFromComponent($address, $component);
        }

        return $address;
    }

    /**
     * update address from google address component
     *
     * @param Address   $address
     * @param object    $component  Google address component object
     * @return Address
     */
    private function updateAddressFromComponent(Address $address, $component) : Address
    {
        foreach ($component->types as $type) {
            switch ($type) {
                case 'postal_code':
                    $address->setPostalCode($component->long_name);
                    break;
                case 'locality':
                case 'postal_town':
                    $address->setLocality($component->long_name);
                    break;
                case 'country':
                    $address->setCountry($component->long_name);
                    $address->setCountryCode($component->short_name);
                    break;
                case 'street_number':
                    $address->setStreetNumber($component->long_name);
                    break;
                case 'route':
                    $address->setStreetName($component->long_name);
                    break;
                case 'administrative_area_level_1':
                case 'administrative_area_level_2':
                case 'administrative_area_level_3':
                case 'administrative_area_level_4':
                case 'administrative_area_level_5':
                case 'sublocality':
                case 'sublocality_level_1':
                case 'sublocality_level_2':
                case 'sublocality_level_3':
                case 'sublocality_level_4':
                case 'sublocality_level_5':
                case 'street_address':
                case 'intersection':
                case 'political':
                case 'colloquial_area':
                case 'ward':
                case 'neighborhood':
                case 'premise':
                case 'subpremise':
                case 'natural_feature':
                case 'airport':
                case 'park':
                case 'point_of_interest':
                case 'establishment':
                    // TODO implements method
                    break;
                default:
            }
        }

        return $address;
    }
}