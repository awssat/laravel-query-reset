<?php

namespace Awssat\QueryReset;

class EloquentReset
{
    protected static $statements = [
            'with' => ['variable' => 'eagerLoad', 'set' => []],
            'eagerLoad' => ['variable' => 'eagerLoad', 'set' => []],
            'scopes' => ['variable' => 'scopes', 'set' => []],
    ];

    public static function getMethods() 
    {
        return array_keys(static::$statements);
    } 

    public static function __callStatic($name, $arguments)
    {
        $name = lcfirst(str_replace('reset', '', $name));

        if (array_key_exists($name, static::$statements)) {
            $currentStatement = static::$statements[$name];

            return function () use ($name, $currentStatement) {
                $cname = $currentStatement['variable'];

                $this->{$cname} = $currentStatement['set'];

                return $this;
            };
        }
    }
}