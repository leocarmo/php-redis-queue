# PHP Redis Queue

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/leocarmo/php-redis-queue/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/leocarmo/php-redis-queue/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/leocarmo/php-redis-queue/badges/build.png?b=master)](https://scrutinizer-ci.com/g/leocarmo/php-redis-queue/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/leocarmo/php-redis-queue/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Total Downloads](https://img.shields.io/packagist/dt/leocarmo/php-redis-queue.svg)](https://packagist.org/packages/leocarmo/php-redis-queue)

## Starting with composer
`composer require leocarmo/php-redis-queue`

> For examples, see `examples` folder on this project

## The Publisher 

```php
use LeoCarmo\RedisQueue\Publisher;

$redis = new Redis();
$redis->connect('localhost');

Publisher::setQueueClient('my-queue', $redis);

Publisher::pushMessage('my-queue', [
    'message' => 'Hello World!'
]);
```

## The Listener

```php
use LeoCarmo\RedisQueue\Listener;

$redis = new Redis();
$redis->connect('localhost');

Listener::setQueueClient('my-queue', $redis);

Listener::restoreMessagesFromProcessingQueue('my-queue', 1);

while (true) {
    Listener::processMessages('my-queue', 1, 1, function ($events) {
        dump($events);
    });
}
```

> Tests soon

## Credits
- [Leonardo Carmo](https://github.com/leocarmo)
