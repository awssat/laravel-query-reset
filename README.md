

![laravel-query-reset](https://i.imgur.com/iqraynn.jpg)



[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)


## Introduction
Clear previously set statements in Laravel query builder/Eloqent builder easily.


## Features
- Support most of query builder statemets. (where, limit, order etc..)
- Intuitive, just type ->reset{..} followed by the statement name like: resetLimit()
- Well tested (check tests folder).
- Easy to use .. 


## Install

Via Composer
``` bash
composer require awssat/laravel-query-reset
```

### Before Laravel 5.5
You'll need to manually register `Awssat\QueryReset\QueryResetServiceProvider::class` service provider in `config/app.php`.

## Usage
| Query\Builder method | Description |
| --- | --- |
| resetOrder() | remove all `order by ...` statements from the query |
| resetLimit() | remove all `limit ...` statements from the query |
| resetOffset() | remove all `offset ...` statements from the query |
| resetHaving() | remove all `having ...` statements from the query |
| resetWhere() | remove all `where ...` statements from the query |
| resetSelect() | remove all `select ...` statements from the query |
| resetJoin() | remove all `join ...` statements from the query |
| resetDistinct() | remove all `distinct ...` statements from the query |
| resetGroup() | remove all `group by ...` statements from the query |
| resetAggregate() | remove all aggregate's methods statements from the query such as `count`, `max`, `min`, `avg`, and `sum`. |

| Eloquent\Builder method | Description |
| --- | --- |
| resetWith() or resetEagerLoad() | remove all eager Loads  |
| resetScopes() | remove all restrictive scopes  |


### Examples
```php
$model->orderBy('id')->resetOrder()
```

```php
$model->with('items')->resetWith()
```

## Usage case
if you're using statements in your relations defining methods or using built in laravel realtions that's using statement by default such as `order by` or a model's scope that interfere with your query ... and you don't want that for a specific query call .. use this package.



## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Credits
- [All Contributors][link-contributors]


[ico-version]: https://img.shields.io/packagist/v/awssat/laravel-query-reset.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/awssat/laravel-query-reset
[link-contributors]: ../../contributors

