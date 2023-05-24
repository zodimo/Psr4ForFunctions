<?php declare(strict_types=1);

require(__DIR__ . '/../vendor/autoload.php');

use Zodimo\Psr4ForFunctions\Autoloader;
use function MyApp\sum;


$autoloader = new Autoloader();
$autoloader->registerAutoloader();


try {
    $total = sum(1, 2);
} catch (Error $e) {
    $message = $e->getMessage();
    if (!str_contains($message, "Call to undefined function")) {
        throw $e;
    }

    //Autoloader did not receive the call..

    preg_match('/.*\s(?<functionFQDN>.*?)\(\)$/', $message, $matches);
    if (!!!($matches['functionFQDN'] ?? null)) {
        throw $e;
    }
    $functionName = $matches['functionFQDN'];
    
    // use psr4 to determine the file to include
    // can we load it and try again ?

    echo "The function you called which may or may not exist is: $functionName\n";

}



