<?php declare(strict_types=1);

namespace MyApp;

use Zodimo\Psr4ForFunctions\FunctionLoaderTrait;

/**
 * @method static int sum(int $a, int $b)
 */
class Math
{
    use FunctionLoaderTrait;
}