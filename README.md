# Geolocation klasa obsługująca Google Maps API
[![Latest Stable Version](http://img.shields.io/packagist/v/juskiewicz/geolocation.svg)](https://packagist.org/packages/juskiewicz/geolocation)
[![License](http://img.shields.io/badge/license-MIT-lightgrey.svg)](https://github.com/juskiewicz/geolocation/blob/master/LICENSE)

Klasa Geolocation łączy się z Google Maps API i wyszukuje współrzędne lub adres.

## Instalacja

### Composer

Za pomocą [Composer](https://getcomposer.org) możesz zawsze pobrać najnowszą wersję.

``` json
composer require juskiewicz/geolocation
```
Sprawdź w [Packagist](https://packagist.org/packages/juskiewicz/geolocation).

### Przykłady użycia

**getCoordinatesByObject**

> Pobiera obiekt Coordinates za pomocą obiektu Address.

``` php
$streetName = 'Maltańska';
$streetNumber = '1',
$postalCode = '61-131',
$locality = 'Poznań',
$country = 'Polska',

$address = new Address(
    null,
    $streetName,
    $streetNumber,
    $postalCode,
    $locality,
    $country
);

$geolocation = new Geolocation('YOUR_GOOGLE_MAPS_API_KEY', 'pl', 'pl');
$coordinates = $coordinates = $geolocation->getCoordinatesByObject($address);

// Współrzędne
$latitude = $coordinates->getLatitude();
$longitude = $coordinates->getLongitude();
$tablica = $coordinates->toArray();
```

**getCoordinatesByString**

> Pobiera obiekt Coordinates za pomocą stringu.

``` php
$address = "Maltańska 1, 61-131 Poznań, Polska";
$geolocation = new Geolocation('YOUR_GOOGLE_MAPS_API_KEY', 'pl', 'pl');
$coordinates = $geolocation->getCoordinatesByString($address);
```

**getAddress**

> Pobiera obiekt Address za pomocą obiektu Coordinates.

``` php
$latitude = 51.8990865;
$longitude = 17.7863699;

$coordinates = new Coordinates($latitude, $longitude);

$geolocation = new Geolocation('YOUR_GOOGLE_MAPS_API_KEY','pl', 'pl');
$address = $geolocation->getAddress($coordinates);
```

Sprawdź źródło [ klasy Geolocation](./src/Geolocation.php).
Sprawdź źródło [ klasy Address](./src/Model/Address.php).
Sprawdź źródło [ klasy Coordinates](./src/Model/Coordinates.php).