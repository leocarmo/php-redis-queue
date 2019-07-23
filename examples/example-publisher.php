<?php

require '../vendor/autoload.php';

use LeoCarmo\RedisQueue\Publisher;

$redis = new Redis();
$redis->connect('localhost');

//Publisher::setDefaultQueueClient($redis);
Publisher::setQueueClient('my-queue', $redis);

while (true) {
    Publisher::pushMessage('my-queue', [
        'message' => 'Hello World!',
        'something' => rand(1, 10),
    ]);
}