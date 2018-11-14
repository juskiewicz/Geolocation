<?php
/*
 * Przykład pobrania adresu przy użyciu obiektu coordinates
 */

require __DIR__.'/../vendor/autoload.php';

use Juskiewicz\Geolocation\Geolocation;
use Juskiewicz\Geolocation\Model\Coordinates;

// create coordinates object
$coordinates = new Coordinates(51.8990865, 17.7863699);

$geolocation = new Geolocation('YOUR_GOOGLE_MAPS_API_KEY','pl', 'pl');
$address = $geolocation->getAddress($coordinates);

var_dump($address);