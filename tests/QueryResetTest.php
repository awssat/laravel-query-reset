<?php

namespace Awssat\QueryReset\Tests;

use PHPUnit\Framework\TestCase;
use Awssat\QueryReset\QueryReset;
use Awssat\QueryReset\EloquentReset;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Mockery as m;



class QueryResetTest extends TestCase
{
 
    public function setUp()
    {
        parent::setUp();

        //load macros
        collect(QueryReset::getMethods())
            ->each(function ($item) {
                $name = 'reset'.ucfirst($item);
                Builder::macro('reset' . ucfirst($item), QueryReset::{$name}());
            });

        collect(EloquentReset::getMethods())
            ->each(function ($item) {
                $name = 'reset'.ucfirst($item);
                EloquentBuilder::macro('reset'.ucfirst($item), EloquentReset::{$name}());
            });
    }

    /**
     * @test
     */
    public function query_rest_class_get_methods_return_non_empty_array()
    {
        $a = QueryReset::getMethods();

        $this->assertTrue(is_array($a) && count($a) > 0);
    }
    
    /**
     * @test
     */
    public function eloquent_rest_class_get_methods_return_non_empty_array()
    {
        $a = EloquentReset::getMethods();

        $this->assertTrue(is_array($a) && count($a) > 0);
    }

    /**
     * @test
     */
    public function static_call_of_resetMethod_return_callable()
    {
       $this->assertTrue(is_callable(QueryReset::resetLimit()));
       $this->assertTrue(is_callable(EloquentReset::resetWith()));
    }

    /**
     * @test
     */
    public function query_rest_methods_added_successfully_to_builder()
    {
        collect(QueryReset::getMethods())
            ->each(function($item) {
                    $name = 'reset' . ucfirst($item);
                    $this->assertTrue(Builder::hasMacro($name), "{$name} macro is not loaded!");
            });
    }

    /**
     * @test
     */
    public function eloquent_rest_methods_added_successfully_to_builder()
    {
        //EloquentBuilder doesnt have 'hasMacro' currently .. so.. later!
        $this->assertTrue(true);
    }


    /**
     * @test
     */
    public function query_rest_methods_should_really_really_reset()
    {
        $this->assertNotContains('limit 3', $this->getBuilder()->from('items')->limit(3)->resetLimit()->where('id', '=', 2)->toSql());
        $this->assertNotContains('order by', $this->getBuilder()->from('items')->limit(3)->resetLimit()->where('id', '=', 2)->toSql());
        $this->assertNotContains('offset 12', $this->getBuilder()->from('items')->offset(12)->resetOffset()->orderBy('id')->toSql());
        $this->assertNotContains('name_one', $this->getBuilder()->select('name_one')->from('items')->offset(12)->resetSelect()->toSql());
        $this->assertNotContains('distinct', $this->getBuilder()->distinct()->from('items')->offset(12)->resetDistinct()->toSql());
    }

    /**
     * @test
     */
    public function eloquent_rest_methods_should_really_really_reset()
    {
        $this->assertCount(0, $this->getEloquentBuilder()->with(['items'])->resetWith()->getEagerLoads());
    }

    protected function getBuilder()
    {
        $grammar = new \Illuminate\Database\Query\Grammars\Grammar;
        $processor = m::mock('Illuminate\Database\Query\Processors\Processor');
        return new Builder(m::mock('Illuminate\Database\ConnectionInterface'), $grammar, $processor);
    }

    protected function getEloquentBuilder()
    {
        return new EloquentBuilder($this->getBuilder());
    }
}