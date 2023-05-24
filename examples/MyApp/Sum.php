<?php declare(strict_types=1);

namespace MyApp;

class Sum
{
    private function __construct()
    {
    }

    public static function create(): self
    {
        return new self();
    }

    public function __invoke(int $a, int $b): int
    {
        return  $a + $b;
    }

}