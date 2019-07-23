<?php

require '../vendor/autoload.php';

use LeoCarmo\RedisQueue\Listener;

$redis = new Redis();
$redis->connect('localhost');

//Listener::setDefaultQueueClient($redis);
Listener::setQueueClient('my-queue', $redis);

// If the worker crash, we need to restore the processing messages
Listener::restoreMessagesFromProcessingQueue('my-queue', 2);

while (true) {
    Listener::processMessages('my-queue', 2, 1, function ($events) {
        dump($events);
    });
}