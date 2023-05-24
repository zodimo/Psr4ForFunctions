<?php declare(strict_types=1);

require(__DIR__ . '/../vendor/autoload.php');


$total = \MyApp\Sum::create()(1, 2);
echo "Total: $total\n";



