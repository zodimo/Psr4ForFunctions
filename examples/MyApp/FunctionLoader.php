<?php declare(strict_types=1);

namespace MyApp;

trait FunctionLoader
{
    private static self $instance;
    private static bool $initialized = false;

    /** @var string[] */
    private array $loadedFunctions = [];

    private function __construct()
    {
        static::$initialized = true;
    }

    private function isFunctionLoaded(string $functionName): bool
    {
        return key_exists($functionName, $this->loadedFunctions);
    }

    private function prepareFunctionSource(string $code): string
    {
        //remove open and closing php stags if they exist.
        $openTagPattern = '/^<\?php.*?\n/';
        $namespacePattern = '/^\s*namespace .*?\n/';
        $closeTagPattern = '/\?>\s*$/';
        $withoutOpenTag = preg_replace($openTagPattern, '', $code);
        $withoutNamespace = preg_replace($namespacePattern, '', $withoutOpenTag);
        $withoutClosingTag = preg_replace($closeTagPattern, '', $withoutNamespace);
        return trim($withoutClosingTag);
    }

    private function generateUniqueFunctionNameFor(string $functionName): string
    {
        $timestamp = time();
        return "{$functionName}{$timestamp}";
    }

    private function renameFunctionInCode(string $newFunctionName, string $code): string
    {
        $replaceFunctionNamePattern = '/\s*function\s* \w+\s*?\(/';
        $codeSnippet = "function {$newFunctionName} (";
        return preg_replace($replaceFunctionNamePattern, $codeSnippet, $code, 1);
    }

    private function loadFunction(string $functionName)
    {
        if ($this->isFunctionLoaded($functionName)) {
            return;
        }
        $functionSource = __DIR__ . "/functions/{$functionName}.php";
        $code = $this->prepareFunctionSource(file_get_contents($functionSource));
        //rename function to unique value to avoid collision
        $newFunctionName = $this->generateUniqueFunctionNameFor($functionName);
        eval($this->renameFunctionInCode($newFunctionName, $code));
        $this->loadedFunctions[$functionName] = $newFunctionName;
    }

    private function getQualifiedFunctionName(string $functionName): string
    {
        return $this->loadedFunctions[$functionName];
    }

    private function callFunction(string $functionName, array $arguments = [])
    {
        $qualifiedFunctionName = $this->getQualifiedFunctionName($functionName);
        echo "callFunction: {$functionName} at {$qualifiedFunctionName}\n";
        return call_user_func_array($qualifiedFunctionName, $arguments);
    }


    public static function __callStatic($name, $arguments)
    {
        if (!static::$initialized) {
            static::$instance = new self();
        }

        $instance = static::$instance;

        if (!$instance->isFunctionLoaded($name)) {
            $instance->loadFunction($name);
        }
        return $instance->callFunction($name, $arguments);
    }
}