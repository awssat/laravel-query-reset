<?php

namespace Awssat\QueryReset;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class QueryResetServiceProvider extends ServiceProvider
{
    /**
     * Add ->reset* methods to query builder
     */
    public function register()
    {
        //Query builder
        Collection::make(QueryReset::getMethods())
            ->reject(function($method) {
                return Builder::hasMacro('reset'. ucfirst($method));
            })
            ->each(function($method) {
                Builder::macro('reset'. ucfirst($method), QueryReset::$method());
            });
        
        //Eloquent builder
        Collection::make(EloquentReset::getMethods())
            ->reject(function($method) {
                return EloquentBuilder::hasMacro('reset'. ucfirst($method));
            })
            ->each(function($method) {
                EloquentBuilder::macro('reset'. ucfirst($method), EloquentReset::$method());
            });
    }
}
