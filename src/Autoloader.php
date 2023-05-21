<?php declare(strict_types=1);

namespace Zodimo\Psr4ForFunctions;

use Composer\Composer;

class Autoloader
{
    public function registerAutoloader()
    {
        $couldRegisterAutoloader = spl_autoload_register(function ($classOrFunction) {
            dd($classOrFunction);
        });
        if (!$couldRegisterAutoloader) {
            throw new \Exception("Could not register function autoloader");
        }
    }


}