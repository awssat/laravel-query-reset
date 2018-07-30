<?php

namespace Awssat\QueryReset;

class QueryReset
{
    protected static $statements = [
            'order' => ['variable' => 'orders', 'unions' => true, 'set' => null],
            'limit' => ['variable' => 'limit', 'unions' => true, 'set' => null],
            'offset' => ['variable' => 'offset', 'unions' => true, 'set' => null],
            'having' => ['variable' => 'havings', 'set' => null],
            'where' => ['variable' => 'wheres', 'set' => []],
            'select' => ['variable' => 'columns', 'set' => null],
            'join' => ['variable' => 'joins', 'set' => null],
            'distinct' => ['variable' => 'distinct', 'set' => null],
            'aggregate' => ['variable' => 'aggregate', 'set' => null],
            'group' => ['variable' => 'groups', 'set' => null],
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
                $unions = $currentStatement['unions'] ?? false;

                $this->{$this->unions && $unions ? 'unions'.ucfirst($cname) : $cname} = $currentStatement['set'];

                return $this;
            };
        }
    }
}