<?php
/*
 * Przykład pobrania lokalizacji przy użyciu obiektu addresss
 */

require __DIR__.'/../vendor/autoload.php';

use Juskiewicz\Geolocation\Geolocation;
use Juskiewicz\Geolocation\Model\Address;

// create address object
$address = new Address(
    null,
    'Maltańska',
    1,
    '61-131',
    'Poznań',
    'Polska'
);

$geolocation = new Geolocation('YOUR_GOOGLE_MAPS_API_KEY', null, null);
$coordinates = $geolocation->getCoordinates($address);

var_dump($coordinates);