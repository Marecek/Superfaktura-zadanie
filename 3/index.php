<?php

$loader = require __DIR__ . '/vendor/autoload.php';

use CoById\CoById;
use CoById\Exception\ExcError;

$companyById = new CoById('https://ares.gov.cz/ekonomicke-subjekty-v-be/rest/ekonomicke-subjekty');

try {
    $response = $companyById->getCompanyById('01569651');
} catch (ExcError $e) {
    $response = false;
}

if ($response) {
    echo '<pre>';
    print_r($response->toArray());
    echo '</pre>';
}


