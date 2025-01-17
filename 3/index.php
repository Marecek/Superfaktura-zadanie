<?php

$loader = require __DIR__ . '/vendor/autoload.php';

use CoById\CoById;

$companyById = new CoById('https://ares.gov.cz/ekonomicke-subjekty-v-be/rest/ekonomicke-subjekty');

$response = $companyById->getCompanyById('01569651');

echo '<pre>';
print_r( $response->toArray());
echo '</pre>';
 ?>

