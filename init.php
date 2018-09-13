<?php

if (! class_exists('RestClient')) {
    die('Esta versión de SDK SrPago requiere la librería RestClient. La clase RestClient no existe');
}

// SrPago singleton
require dirname(__FILE__).'/lib/SrPago.php';

// Errors
require dirname(__FILE__).'/lib/Error/SrPagoError.php';

//HttpClient
require dirname(__FILE__).'/lib/Http/HttpClient.php';

require dirname(__FILE__).'/lib/Util/Encryption.php';

// Resources
require dirname(__FILE__).'/lib/Base.php';

// SrPago API Resources
require dirname(__FILE__).'/lib/Token.php';
require dirname(__FILE__).'/lib/Operations.php';
require dirname(__FILE__).'/lib/Charges.php';
require dirname(__FILE__).'/lib/Customer.php';
