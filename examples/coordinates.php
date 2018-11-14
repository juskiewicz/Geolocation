<?php
/*
 * Przykłady pobrania lokalizacji
 */

require __DIR__.'/../vendor/autoload.php';

use Juskiewicz\Geolocation\Geolocation;
use Juskiewicz\Geolocation\Model\Address;

/*
 * Pobranie lokalizacji za pomocą obiektu
 */
$address = new Address(
    null,
    'Maltańska',
    1,
    '61-131',
    'Poznań',
    'Polska'
);

$geolocation = new Geolocation('YOUR_GOOGLE_MAPS_API_KEY', null, null);
$coordinates = $geolocation->getCoordinatesByObject($address);
var_dump($coordinates);

/*
 * Pobranie lokalizacji za pomocą stringu
 */
$address = "Maltańska 1, 61-131 Poznań, Polska";
$geolocation = new Geolocation('YOUR_GOOGLE_MAPS_API_KEY', null, null);
$coordinates = $geolocation->getCoordinatesByString($address);
var_dump($coordinates);