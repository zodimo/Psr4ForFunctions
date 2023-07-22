<?php declare(strict_types=1);

require(__DIR__ . '/../vendor/autoload.php');


//$total1 = \MyApp\Math::sum2(1, 2);
$total1 = \MyApp\Math::sum(1, 2);
echo "Total1: $total1\n";
$total2 = \MyApp\Math::sum(2, 2);
echo "Total2: $total2\n";
