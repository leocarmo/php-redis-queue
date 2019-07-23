<?php

require '../vendor/autoload.php';

use \LeoCarmo\RedisQueue\Manager;

$redis = new Redis();
$redis->connect('localhost');

$queue = 'my-queue';

//Manager::setDefaultQueueClient($redis);
Manager::setQueueClient($queue, $redis);

echo Manager::countMessagesInQueue($queue) . PHP_EOL;
dump(Manager::getMessagesFromQueue($queue, 0, 9));

Manager::removeMessagesFromQueue($queue);
echo Manager::countMessagesInQueue($queue) . PHP_EOL;
